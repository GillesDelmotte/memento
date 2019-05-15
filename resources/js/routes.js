import Meet from './components/Meet';
import Notif from './components/Notif';
import Practitioners from './components/Practitioners';
import PractitionersFilter from './components/PractitionersFilter';
import Practitioner from './components/Practitioner';
import PractitionerSchedule from './components/PractitionerSchedule';
import Schedule from './components/Schedule';
import NewSchedule from './components/NewSchedule';
import ScheduleRouter from './components/ScheduleRouter';
import ScheduleList from './components/ScheduleList';
import Menu from './components/Menu';
import Profile from './components/Profile';
import Admin from './components/Admin';
import AdminStat from './components/AdminStat';
import AdminReport from './components/AdminReport';

export default [
    { path: '/', redirect: '/meet' },
    {
        path: '/meet',
        name: 'meet',
        component: Meet
    },
    {
        path: '/notifications',
        name: 'notif',
        component: Notif
    },
    {
        path: '/praticiens',
        name: 'practitioners',
        component: Practitioners,
        children: [
            {
                path: '/praticiens',
                name: 'practitionersFilter',
                component: PractitionersFilter
            },
            {
                path: '/praticiens/:id',
                name: 'practitioner',
                component: Practitioner
            },
            {
                path: '/praticiens/:id/horaire',
                name: 'practitionerSchedule',
                component: PractitionerSchedule
            },


        ]
    },
    {
        path: '/horaire',
        name: 'schedule',
        component: Schedule
    },
    {
        path: '/mes-horaires',
        name: 'ScheduleRouter',
        component: ScheduleRouter,
        children: [
            {
                path: '/mes-horaires',
                name: 'scheduleList',
                component: ScheduleList
            },
            {
                path: '/nouvel-horaire',
                name: 'newSchedule',
                component: NewSchedule
            },

        ]
    },
    {
        path: '/menu',
        name: 'menu',
        component: Menu
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin,
        children: [
            {
                path: '/admin-statistiques',
                name: 'adminStat',
                component: AdminStat
            },
            {
                path: '/admin-report',
                name: 'adminReport',
                component: AdminReport
            }

        ]
    },

]