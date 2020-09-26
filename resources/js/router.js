import Vue from "vue";
import VueRouter from "vue-router";

//Navigation Start
import Home from "./components/pages/Home";
import Newsfeed from "./components/pages/Newsfeed";
import Pricing from "./components/pages/Pricing";
import Billing from "./components/pages/Billing";

//Mail
import Mailbox from "./components/pages/mailbox/Mailbox";
import Compose from "./components/pages/mailbox/Compose";
import Single from "./components/pages/mailbox/Single";

//Message
import Chat from "./components/pages/chat/Chat";
import Conversations from "./components/pages/chat/Conversations";

//Writers
import Write from "./components/pages/writers/Write";
import MyPosts from "./components/pages/writers/MyPosts";

//Broadcasters
import Broadcasts from "./components/pages/broadcasters/Broadcasts";

import Members from "./components/pages/Members";
import Users from "./components/pages/Users";
import Profile from "./components/pages/Profile";

import ChatRoom from "./components/pages/ChatRoom";

import Settings from "./components/pages/Settings";

import NotFound from "./components/pages/NotFound";
import Forbidden from "./components/pages/Forbidden";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/dashboard",
            name: "Home",
            component: Home,
            meta: {
                noAccessForViewers: true
            } 
        },
        {
            path: "/dashboard/newsfeed",
            name: "Newsfeed",
            component: Newsfeed
        },
        // {
        //     path: "/dashboard/mailbox",
        //     name: "Mailbox",
        //     component: Mailbox
        // },
        // {
        //     path: "/dashboard/compose",
        //     name: "Compose",
        //     component: Compose
        // },
        // {
        //     path: "/dashboard/mail/:slug",
        //     name: "Single",
        //     component: Single
        // },
        {
            path: "/dashboard/members",
            name: "Members",
            component: Members
        },
        {
            path: "/dashboard/users",
            name: "Users",
            component: Users,
            meta: {
                requiresAdminAccess: true
            } 
        },
        {
            path: "/dashboard/profile/:slug",
            name: "Profile",
            component: Profile
        },
        {
            path: "/dashboard/write",
            name: "Write",
            component: Write,
            meta: {
                requiresWriterAccess: true
            } 
        },
        {
            path: "/dashboard/my-posts",
            name: "MyPosts",
            component: MyPosts,
            meta: {
                requiresWriterAccess: true
            } 
        },
        {
            path: "/dashboard/broadcasts",
            name: "Broadcasts",
            component: Broadcasts,
            meta: {
                requiresBroadcasterAccess: true
            } 
        },
        // {
        //     path: "/dashboard/pricing",
        //     name: "Pricing",
        //     component: Pricing
        // },
        // {
        //     path: "/dashboard/billing",
        //     name: "Billing",
        //     component: Billing
        // },
        // {
        //     path: "/dashboard/chat/:slug",
        //     name: "Chat",
        //     component: Chat
        // },
        // {
        //     path: "/dashboard/chat",
        //     name: "Conversations",
        //     component: Conversations
        // },
        // {
        //     path: "/dashboard/chatroom",
        //     name: "ChatRoom",
        //     component: ChatRoom
        // },
        {
            path: "/dashboard/settings",
            name: "Settings",
            component: Settings,
            meta: {
                requiresAdminAccess: true
            } 
        },
        {
            path: "/forbidden",
            name: "Forbidden",
            component: Forbidden
        },
        {
            path: "/404",
            name: "404",
            component: NotFound
        },
        {
            path: "*",
            redirect: "/404"
        }
    ],

    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return {
                x: 0,
                y: 0
            };
        }
    }
});

export default router;
