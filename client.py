import socket
import pymysql
import importlib
import address
import chatClient

def Register():
    isTaken = False

    while not isTaken:
        username = raw_input("Username: ")

        # Check if username is taken
        db = pymysql.connect("localhost", "", "", "chat")
        cursor = db.cursor()
        cursor.execute("SELECT username FROM users")
        usersResult = cursor.fetchall()

        isTaken = True
        for i in range(len(usersResult)):
            if usersResult[i][0] == username:
                print "\nERROR - Username already taken!\n"
                isTaken = False
        if not isTaken:
            username = raw_input("Username: ")

    password = raw_input("Password: ")

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((address.HOST, address.PORT))

    s.sendall("register " + " " + username + " " + password)
    data = s.recv(1024)

    s.close()

def Validate(username, password):
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((address.HOST, address.PORT))

    s.sendall("validate " + " " + username + " " + password)
    data = s.recv(1024)

    s.close()
    return data


def ChatSession(myUsername, theirUsername, alg):
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((address.HOST, address.PORT))

    print "CHATROOM:"
    print "You and " + theirUsername + " have joined the chatroom!\n"
    isExitting = False

    s.sendall("message " + " " + myUsername + " " + theirUsername)
    #chatClient.Start()
    s.close()

"""    while not isExitting:
        message = raw_input("<< ")

        # Begin symmetric key (provided by server) encryption of "message"


# View user list
        if message == "!users":
            UsersOnline(myUsername)
# View help
        elif message == "!help":
            print ( "\nCOMMANDS\n" +
                    "'!users' will list all the registered users.\n" +
                    "'!exit' will leave the chatroom.\n")
# Exit chatroom
        elif message == "!exit":
            print "\nLeaving the chatroom...\n"
            isExitting = True
# Send message
        else:
            s.sendall("message " + " " + message + " " + myUsername + " " + theirUsername)

    s.close()
"""

# Prints users online and their status
def UsersOnline(myUsername):
    db = pymysql.connect("localhost", "", "", "chat")
    cursor = db.cursor()

    cursor.execute("SELECT username FROM users")
    usersResult = cursor.fetchall()

    cursor.execute("SELECT status FROM users")
    statusResult = cursor.fetchall()

    offlineUsers = []

    print "\nOFFLINE USERS:"
    for i in range(len(usersResult)):
        if usersResult[i][0] != myUsername:
            if statusResult[i][0] == "Offline":
                print usersResult[i][0]
            else:
                offlineUsers.append(usersResult[i][0])
    print "\nONLINE USERS: \n" + "\n".join(offlineUsers) + "\n"
    db.close()
