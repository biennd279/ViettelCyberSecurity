//
// Created by bien on 28/08/2020.
//

#include <iostream>
#include <string>

#include <cstring>
#include <pwd.h>
#include <shadow.h>
#include <crypt.h>

using std::string;
using std::cout;
using std::cin;
using std::cerr;

bool is_correct_passwd(const string& user_name, const string& password) {
    auto pwd = getpwnam(user_name.c_str());
    if (pwd == nullptr) {
        cerr << "Can not find this user!\n";
        exit(1);
    }

    auto sp = getspnam(user_name.c_str());

    if (sp == nullptr) {
        cerr << "Can not get shadow content!\n";
        exit(0);
    }

    string hashed = crypt(password.c_str(), sp->sp_pwdp);

    return hashed == sp->sp_pwdp;
}

int main(int argc, char** args) {
    if (argc == 3) {
        if (is_correct_passwd(args[1], args[2])) {
            cout << "Correct password!\n";
        } else {
            cout << "Do not correct password!\n";
        }
    } else {
        cerr << "Illegal argument!\n";
        exit(1);
    }
}

