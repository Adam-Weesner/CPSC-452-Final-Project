import socket
import pymysql
import importlib
import address
import select
import sys
import time
import address
import hashlib, uuid
import pvtPubKeys
from base64 import b64encode, b64decode
import account

account = account.Account("", object(), object())
#privateKey = object()
#publicKey = object()

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

    account.name = username

    salt = uuid.uuid4().hex
    hashed_password = hashlib.sha512(password + salt).hexdigest()

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((address.HOST, address.PORT))

    s.sendall("register " + " " + username + " " + str(hashed_password))
    data = s.recv(1024)

    cursor.execute("UPDATE users SET salt = '{0}' WHERE username = '{1}'".format(salt, username))
    db.commit()

    s.close()


def Validate(username, password):
    # Get user's salt value and rehash password
    db = pymysql.connect("localhost", "", "", "chat")
    cursor = db.cursor()
    cursor.execute("SELECT salt FROM users WHERE username = '{0}'".format(username))
    result = cursor.fetchone()

    hashed_password = ""
    if result:
        salt = str(result[0])

        hashed_password = hashlib.sha512(password + salt).hexdigest()

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((address.HOST, address.PORT))

    s.sendall("validate " + " " + username + " " + hashed_password)
    data = s.recv(1024)

    s.close()
    db.close()

    # Get new private/public keys
    if data == "true":
        isDone = False
        print ""
        while not isDone:
            choice = raw_input("Create private/keys using RSA or DCA? ").upper()
            if choice == "RSA" or choice == "DCA":
                account.privateKey = pvtPubKeys.GeneratesKeys(choice)
                account.publicKey = account.privateKey.publickey()
                isDone = True
            else:
                print "\nERROR - Please input either RSA or DCA!\n"
    return data


def ChatSession(myUsername, theirUsername):
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((address.HOST, address.PORT))

    # Encrypt symmetric Key using RSA or DCA algorithms.
    isDone = False
    choice = ""
    print ""
    while not isDone:
        choice = raw_input("RSA or DCA for symmetric key encryption? ").upper()
        if choice == "RSA" or choice == "DCA":
            isDone = True
        else:
            print "\nERROR - Please input either RSA or DCA!\n"


    # Invited user sends other info to server
    s.sendall("message" + " " + myUsername + " " + theirUsername + " " + choice)
    symmetricKey = s.recv(1024)

    # Encrypt symmetricKey using user's public key
    print publicKey
    time.sleep(.1)
    #encryptedSymmetricKey = b64encode(pvtPubKeys.EncryptSymmetric(symmetricKey, publicKey))

    print "Encrypted Symmetric Key: "
    #print encryptedSymmetricKey

    print "CHATROOM:"
    print "You and " + theirUsername + " have joined the chatroom!\n"

    isExitting = False

    while not isExitting:
        sockets_list = [sys.stdin, s]
        read_sockets,write_socket, error_socket = select.select(sockets_list,[],[])

        for socks in read_sockets:
            if socks == s:
                time.sleep(.1)
                message = socks.recv(2048)
                if message != "message":
                    print message
            else:
                message = raw_input("")
# Invite another user
                if message[0:8] == "!invite ":
                    db = pymysql.connect("localhost", "", "", "chat")
                    cursor = db.cursor()
                    cursor.execute("SELECT username FROM users WHERE username = '{0}'".format(message[8::]))
                    result = cursor.fetchone()
                    if result:
                        if message[8::] != myUsername:
                            cursor.execute("SELECT status FROM users WHERE username = '{0}'".format(message[8::]))
                            status = cursor.fetchone()
                            if message[0] == "Online":
                                print "\nInvite send to " + message[8::] + "!"
                            else:
                                print "\nERROR - " + message[8::] + " is not online at the moment!\n"
                        else:
                            print "\nERROR - You cannot invite yourself!\n"
                    else:
                        print "\nERROR - Cannot find " + message[8::] + "!\n"
                    db.close()
# View user list
                elif message == "!users":
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
                    s.send(message)
# Send message
                else:
                    s.send(message)
    time.sleep(.1)
    s.close()



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
