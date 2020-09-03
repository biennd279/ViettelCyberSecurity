#include <iostream>

#include <unistd.h>
#include <pwd.h>

int main() {

    auto uid = geteuid();
    auto pwd = getpwuid(uid);

    std::cout << pwd->pw_name << std::endl;

    getchar();

    return 0;
}
