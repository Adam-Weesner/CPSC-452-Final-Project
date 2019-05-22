class Account:
    def __init__(self, name = "", publicKey = object(), privateKey = object()):
        # Public attributes
        self.name = name
        self.publicKey = publicKey
        # Private attributes
        self.__privateKey = privateKey
