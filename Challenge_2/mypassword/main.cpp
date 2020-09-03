#include <iostream>

#include <paths.h>
#include <pwd.h>
#include <shadow.h>
#include <unistd.h>

#include <string>
using std::string;
using std::cin;
using std::cout;
using std::cerr;

void change_password(const string &user_name, const string &password) {

    if (setuid(0) != 0) {
        cerr << "Can set uid to root!\n";
        exit(1);
    };

    auto pwd = getpwnam(user_name.c_str());

    if (pwd == nullptr) {
        cerr << "User don't exist!\n";
        exit(1);
    }

    FILE *fsp;
    fsp = fopen(_PATH_SHADOW, "rw");

    if (fsp == nullptr) {
        cerr << "Can not open shadow file!\n";
        exit(1);
    }

    fclose(fsp);

    FILE *cmd = popen("/usr/sbin/chpasswd >/dev/null 2>/dev/null", "w");

    fprintf(cmd, "%s:%s\n", user_name.c_str(), password.c_str());

    pclose(cmd);
}

int main(int argc, char **args) {
    if (argc == 1) {
        string user_name;
        string password;
        cout << "User: ";
        cin >> user_name;
        cout << "Password: ";
        cin >> password;
        change_password(user_name, password);
    } else if (argc == 3) {
        change_password(args[1], args[2]);
    } else {
        cerr << "Error argument!";
        exit(1);
    }

    return 0;
}
