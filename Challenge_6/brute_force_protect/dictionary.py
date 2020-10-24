class Dictionary:
    def __init__(self, usernames, passwords):
        self.usernames = usernames
        self.passwords = passwords


def get_dictionary():
    usernames_file = open('usernames.txt', 'r')
    passwords_file = open('passwords.txt', 'r')

    usernames = usernames_file.read().split('\n')
    passwords = passwords_file.read().split('\n')

    usernames_file.close()
    passwords_file.close()

    return Dictionary(usernames=usernames, passwords=passwords)
