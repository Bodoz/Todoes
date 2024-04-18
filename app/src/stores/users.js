import {defineStore} from "pinia";

import axios from "axios"

export const useUsersStore = defineStore("user",{
    state: () => ({
        show_login: true,
        user: null,
        next: null, //where to go to after login authentication
    }),
    actions: {
        async authorize(credentials) {
            console.log(credentials)
            try{
                const data = await axios.post('api/users/authorize', credentials)
                let user = data.data.data
                console.log(data.data)
                this.user = user
                this.show_login = false
            } catch(error) {
                alert(error)
                console.log(error)
            }
        },
        async authorized(){
            try{
                const data = await axios.get('api/users/authorized')
                let user = data.data.data
                console.log(data.data)
                this.user = user
            } catch(error) {
                alert(error)
                console.log(error)
            }
        }
    },
})

// CREATE TABLE roles (
//     id integer primary key autoincrement,
//     role char(32)
// );
//
// INSERT INTO roles (role) VALUES('admin');
//
// PRAGMA foreign_keys = on ;
//
// CREATE TABLE user_roles (
//     id integer primary key autoincrement,
//     user_id integer,
//     role_id integer,
//     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE ,
//     FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE CASCADE
// );
//
// INSERT INTO user_roles (user_id, role_id) VALUES (1,1);
//
// CREATE UNIQUE INDEX username ON users (username);

/// CREATE INDEX username ON users (username);