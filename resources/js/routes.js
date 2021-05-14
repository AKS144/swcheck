import UserManagement from "./components/Usermanagement";
import Profile from "./components/Profile";
import User from "./components/User";
// Then we register route for User management module.
export const routes= [
    {
      path:"/usermanagement",
      name: "usermanagement",
      component: UserManagement
    },
    {
        path:"/profile",
        name: "profile",
        component: Profile
    },
    {
      path:"/user",
      name: "user",
      component: User
    },
];
