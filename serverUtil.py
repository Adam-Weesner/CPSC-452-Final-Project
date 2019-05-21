import pymysql
import importlib

def Register(username, password):
    print "Registering " + username + "..."

    db = pymysql.connect("localhost", "", "", "chat")
    cursor = db.cursor()
    cursor.execute("INSERT INTO users (username, password) VALUES ('{0}', '{1}')".format(username, password))
    db.commit()
    db.close()

    return "valid"

def Validate(username, password):
    print "Validating user " + username + "..."

    isValid = "false"

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
                # Set user to be Online
                db = pymysql.connect("localhost", "", "", "chat")
                cursor = db.cursor()
                cursor.execute("UPDATE users SET status = 'Online' WHERE username = '{0}'".format(username))
                db.commit()
            else:
                isValid = "ERROR - Password is incorrect!\n"
        else:
            isValid = "ERROR - User already logged in!\n"
    else:
        isValid = "ERROR - Cannot find username!\n"

    return isValid


def SendMessage(sender, receiver):
    print "Sending message from " + sender + " to " + receiver + "..."

    chatserver.Start()

    print "Sent!"
