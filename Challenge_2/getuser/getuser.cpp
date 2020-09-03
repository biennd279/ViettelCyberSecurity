//
// Created by bien on 27/08/2020.
//

#include "getuser.h"

string get_group_belong(uid_t uid, int max_ngroups = 1000) {
    string group_list;

    auto pwd = getpwuid(uid);

    int ngroups = max_ngroups;
    auto* groups = new gid_t [ngroups];

    if (getgrouplist(pwd->pw_name, pwd->pw_gid, groups, &ngroups) == -1) {
        //Try get again
        delete [] groups;
        groups = new gid_t [ngroups];
        getgrouplist(pwd->pw_name, pwd->pw_gid, groups, &ngroups);
    }

    for(int i = 0; i < ngroups; i++) {
        group_list.append(getgrgid(groups[i])->gr_name);
        group_list.append(", ");
    }
    //Remove ", " at last
    group_list.pop_back();
    group_list.pop_back();

    delete [] groups;

    return group_list;
}

string get_user_information(u_int uid) {
    string information;

    string user_name;
    string home_dir;
    string groups;

    auto pwd = getpwuid(uid);

    if (pwd == nullptr) {
        std::cerr << "Can't find that user!\n";
        exit(0);
    }

    user_name = pwd->pw_name;
    home_dir = pwd->pw_dir;
    groups = get_group_belong(pwd->pw_gid);

    information.append("UID:\t" + std::to_string(pwd->pw_uid) + "\n");
    information.append("User name:\t" + user_name + "\n");
    information.append("Home director:\t" + home_dir + "\n");
    information.append("Group:\t" + groups + "\n");

    return information;
}

int main(int argc, char* args[]) {

    int uid;
    if (argc == 1) {
        std::cout << "Enter the UID: ";
        std::cin >> uid;
        std::cout << get_user_information(uid) << std::endl;
    } else if (argc == 2) {
        uid = atoi(args[1]);
        std::cout << get_user_information(uid) << std::endl;
    } else {

    }

}