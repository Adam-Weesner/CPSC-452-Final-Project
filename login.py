# To get pymysql, use pip install pymysql
import pymysql
import importlib

def main():
    print("WELCOME TO CHAT 1.0")

    # Connect to chat server


    username = raw_input("Enter your username: ")
    password = raw_input("Enter your password: ")

    # Server verifies user/pass, if true, then set this user's activity to "Online"






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
                print "\nWelcome " + username + "!"

                # Set status to Online
                db = pymysql.connect("localhost", "", "", "chat")
                cursor = db.cursor()
                cursor.execute("UPDATE users SET status = 'Online' WHERE username = '{0}'".format(username))
                db.commit()
                db.close()
                isExitting = False

                # Get list of users
                UsersOnline(username)
                print "Type '!help' to see a list of commands.\n"

                while not isExitting:
                    command = raw_input("Enter command: ")

                    db = pymysql.connect("localhost", "", "", "chat")
                    cursor = db.cursor()
# Invite
                    if command[0:8] == "!invite ":
                        inviteCommand = command.split(" ")
                        print len(command)
                        if len(command) != 2:
                            db = pymysql.connect("localhost", "", "", "chat")
                            cursor = db.cursor()
                            cursor.execute("SELECT username FROM users WHERE username = '{0}'".format(inviteCommand[1]))
                            result = cursor.fetchone()

                            if result:
                                if result[0] != username:
                                    cursor.execute("SELECT status FROM users WHERE username = '{0}'".format(inviteCommand[1]))
                                    status = cursor.fetchone()
                                    if status[0] == "Online":
                                        Invite(username, inviteCommand[2])
                                    else:
                                        print "\nERROR - " + result[0] + " is not online at the moment!\n"
                            else:
                                print "\nERROR - Cannot find " + inviteCommand[1] + "!\n"
                        else:
                            print "\nERROR - Invite using the form '!invite <name> <RSA/DS>'!"
# Help
                    elif command == "!help":
                        print ( "\nCOMMANDS\n" +
                                "'!invite <name> <RSA/DS>' will open a chat with that person using either RSA or Digital Signature.\n" +
                                "'!users' will list all the registered users.\n" +
                                "'!exit' will quit the program.\n")
# Users
                    elif command == "!users":
                        UsersOnline(username)
# Exit
                    elif command == "!exit":
                        print "\nExiting chatroom. See ya!\n"
                        isExitting = True
                        # Set status to Offline
                        cursor.execute("UPDATE users SET status = 'Offline' WHERE username = '{0}'".format(username))
                        db.commit()
                    else:
                        print "\nERROR - Invalid command! Type '!help' to see a list of commands\n"
                db.close()
            else:
                print "\nERROR - Password is incorrect!"
        else:
            print "\nERROR - User already logged in!"
    else:
        print "\nERROR - Cannot find username!"


# Prints users online and their status
def UsersOnline(myUsername):
    db = pymysql.connect("localhost", "", "", "chat")
    cursor = db.cursor()

    cursor.execute("SELECT username FROM users")
    usersResult = cursor.fetchall()

    cursor.execute("SELECT status FROM users")
    statusResult = cursor.fetchall()

    offlineUsers = []

    print "\nUSERS OFFLINE:"
    for i in range(len(usersResult)):
        if usersResult[i][0] != myUsername:
            if statusResult[i][0] == "Offline":
                print usersResult[i][0]
            else:
                offlineUsers.append(usersResult[i][0])
    print "\nONLINE USERS: \n" + "\n".join(offlineUsers) + "\n"
    db.close()


# Connects to another user
def Invite(myUsername, theirUsername, alg):
    print "\nInviting " + theirUsername + " using " + alg + "...\n"


if __name__== "__main__":
  main()
