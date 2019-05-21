import select
import socket
import sys
import Queue
import serverUtil
import address

server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server.setblocking(0)
server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server.bind((address.HOST, address.PORT))
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
                        if command[0] == "register":
                            results = serverUtil.Register(command[1], command[2])
                        if command[0] == "validate":
                            results = serverUtil.Validate(command[1], command[2])
                    elif len(command) == 4:
                        if command[0] == "message":
                            results = "message"
                            serverUtil.SendMessage(command[1], command[2])

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


if __name__== "__main__":
  main()
