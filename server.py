import select
import socket
import sys
import Queue
import pymysql
import importlib

server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server.setblocking(0)
server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server.bind(('localhost', 4022))
server.listen(5)
inputs = [server]
outputs = []
message_queues = {}

def main():
    print "Server established!\n"

    while inputs:
        readable, writable, exceptional = select.select(
            inputs, outputs, inputs)
        for s in readable:
            if s is server:
                connection, client_address = s.accept()
                connection.setblocking(0)
                inputs.append(connection)
                message_queues[connection] = Queue.Queue()
                print client_address[0] + " is connecting."
            else:
                data = s.recv(1024)
                if data:
                    command = data.split()
                    results = "false"

                    if len(command) == 3:
                        if command[0] == "validate":
                            results = Validate(command[1], command[2])

                    message_queues[s].put(results)

                    if s not in outputs:
                        outputs.append(s)

                else:
                    if s in outputs:
                        outputs.remove(s)
                    inputs.remove(s)
                    s.close()
                    del message_queues[s]

        for s in writable:
            try:
                next_msg = message_queues[s].get_nowait()
            except Queue.Empty:
                outputs.remove(s)
            else:
                s.send(next_msg)

        for s in exceptional:
            inputs.remove(s)
            if s in outputs:
                outputs.remove(s)
            s.close()
            del message_queues[s]


def Validate(username, password):
    isValid = "false"

    print "Validating user " + username + "..."

    # Check if username exists
    db = pymysql.connect("localhost", "", "", "chat")
    cursor = db.cursor()
    cursor.execute("SELECT password FROM users WHERE username = '{0}'".format(username))
    resultPassword = cursor.fetchone()
    db.close()

    if resultPassword:
        # Check if user is already logged in
        db = pymysql.connect("localhost", "", "", "chat")
        cursor = db.cursor()
        cursor.execute("SELECT status FROM users WHERE username = '{0}'".format(username))
        result = cursor.fetchone()
        db.close()

        if result[0] == "Offline":
            # Check if user's password is correct
            db = pymysql.connect("localhost", "", "", "chat")
            cursor = db.cursor()
            cursor.execute("SELECT status FROM users WHERE username = '{0}'".format(username))
            result = cursor.fetchone()
            db.close()

            if password == resultPassword[0]:
                isValid = "true"
                print "Validated.\n"
            else:
                print "ERROR - Password is incorrect!\n"
        else:
            print "ERROR - User already logged in!\n"
    else:
        print "ERROR - Cannot find username!\n"

    return isValid



if __name__== "__main__":
  main()
