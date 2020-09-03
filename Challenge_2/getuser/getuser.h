//
// Created by bien on 27/08/2020.
//

#ifndef PERMISSION_GETUSER_H
#define PERMISSION_GETUSER_H

#include <string>
#include <iostream>
#include <cstring>

#include <pwd.h>
#include <grp.h>

using std::string;

string get_user_information(u_int uid);

#endif //PERMISSION_GETUSER_H
