# To get pymysql, use pip install pymysql
import pymysql
import importlib

db = pymysql.connect("localhost","","","chat" )
cursor = db.cursor()

def main():
    print("WELCOME TO CHAT 1.0")

    # connect to chat server

    # Hard code login
    username = "tester"
    password = "testing"
    """
    username = raw_input("Enter your username: ")
    password = raw_input("Enter your password: ")

    # Server verifies user/pass, if true, then set this user's activity to "Online"
    """


    cursor.execute("SELECT password FROM users WHERE username = '{0}'".format(username))
    result = cursor.fetchone()

    if result:
        if password == result[0]:
            print "\nWelcome " + username

            isExitting = 0

            # Get list of users
            UsersOnline(username)
            print "Type '!help' to see a list of commands.\n"

            while not isExitting:
                command = raw_input("Enter command: ")

                if command[0:8] == "!invite ":
                    cursor.execute("SELECT username FROM users WHERE username = '{0}'".format(command[8:]))
                    result = cursor.fetchone()

                    if result:
                        if result[0] != username:
                            Invite(username, result[0])
                    else:
                        print "\nERROR - Cannot find " + command[8:] + "!\n"

                elif command == "!help":
                    print ( "\nCOMMANDS\n" +
                            "'!invite <name>' will open a chat with that person.\n" +
                            "'!list' will list all the registered users.\n" +
                            "'!exit' will quit the program.\n")

                elif command == "!list":
                    UsersOnline(username)

                elif command == "!exit":
                    print "\nExiting chatroom. See ya!\n"
                    isQuitting = true

                else:
                    print "\nERROR - Invalid command! Type '!help' to see a list of commands\n"

        else:
            print "\nERROR - Password is incorrect!"
    else:
        print "\nERROR - Cannot find username!"

    # disconnect from server
    db.close()


# Prints users online and their status
def UsersOnline(myUsername):
    print "\nUSERS ONLINE:"

    cursor.execute("SELECT username FROM users")
    usersResult = cursor.fetchall()

    cursor.execute("SELECT status FROM users")
    statusResult = cursor.fetchall()
    status = "Offline"

    for i in range(len(usersResult)):
        if statusResult[i][0] == 1:
            status = "Online"

        if usersResult[i][0] != myUsername:
            print usersResult[i][0] + " - " + status

    print ""


# Connects to another user
def Invite(myUsername, theirUsername):
    print "\nInviting " + theirUsername + "...\n"


if __name__== "__main__":
  main()
