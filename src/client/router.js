import Vue from 'vue'
import Router from 'vue-router'
import { scrollBehavior } from '~/utils'

Vue.use(Router)

const page = (path) => () =>
  import(`~/pages/${path}`).then((m) => m.default || m)
const AdminRoutes = [
  {
    path: '/admin/dashboard',
    name: 'admin-dashboard',
    component: page('admin/index.vue'),
  },
  {
    path: '/admin/all-users',
    name: 'all-users',
    component: page('admin/AllUsers.vue'),
  },
  {
    path: '/admin/all-users/:id/user-details/',
    name: 'user-details',
    component: page('admin/UserDetails.vue'),
  },
  {
    path: '/admin/all-games',
    name: 'all-games',
    component: page('admin/AllGames.vue'),
  },
  {
    path: '/admin/all-games/:id/game-details/',
    name: 'game-details',
    component: page('admin/GameDetails.vue'),
  },
  {
    path: '/admin/admin-payments',
    name: 'admin-payments',
    component: page('admin/AdminPayments.vue'),
  },
  {
    path: '/admin/admin-payments/:id/game-payouts/',
    name: 'game-payouts',
    component: page('admin/AdminPayouts.vue'),
  },
  {
    path: '/admin/kyc-validation',
    name: 'admin-kyc',
    component: page('admin/AdminKycValidation.vue'),
  },
  {
    path: '/admin/hear-about-us',
    name: 'hear-about-us',
    component: page('admin/HearAboutUs.vue'),
  },
  {
    path: '/admin/support',
    name: 'admin-support',
    component: page('admin/AdminAllTickets.vue'),
  },
  {
    path: '/admin/support/:id/ticket',
    name: 'admin-support-details',
    component: page('admin/AdminTicketDetails.vue'),
  },
  {
    path: '/admin/configurations',
    name: 'admin-configurations',
    component: page('admin/AdminConfigurations.vue'),
  },
]
const UserRoutes = [
  /*  {
    path: '/user/dashboard',
    name: 'user-dashboard',
    component: page('user/index.vue'),
  }, */
  {
    path: '/user/withdraw',
    name: 'withdraw',
    component: page('user/Withdraw.vue'),
  },
  {
    path: '/user/user-wallet',
    name: 'user-wallet',
    component: page('user/UserWallet.vue'),
  },
  {
    path: '/user/deposit',
    name: 'deposit',
    component: page('user/Deposit.vue'),
  },
  {
    path: '/user/user-payouts',
    name: 'user-payouts',
    component: page('user/UserPayouts.vue'),
  },
  {
    path: '/user/:id/user-payouts-details',
    name: 'user-payouts-details',
    component: page('user/UserPayoutsDetails.vue'),
  },
  {
    path: '/user/games-history',
    name: 'games-history',
    component: page('user/GamesHistory.vue'),
  },
  {
    path: '/user/current-games',
    name: 'current-games',
    component: page('user/UserCurrentGames.vue'),
  },
  {
    path: '/user/all-games/:id/game-history',
    name: 'gameplay-history',
    component: page('user/GameplayHistory.vue'),
  },
  {
    path: '/user/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'profileSettings.profile' } },
      {
        path: 'update-profile',
        name: 'profileSettings.profile',
        component: page('settings/profilesetting.vue'),
      },
      {
        path: 'update-password',
        name: 'profileSettings.password',
        component: page('settings/updatepassword.vue'),
      },
    ],
  },
  {
    path: '/user/user-invitation',
    name: 'user-invitation',
    component: page('user/UserInvitation.vue'),
  },
  {
    path: '/user/kyc-validation',
    name: 'kyc-validation',
    component: page('user/KycValidation.vue'),
  },
  {
    path: '/user/support',
    name: 'user-support',
    component: page('user/UserAllTickets.vue'),
  },
  {
    path: '/user/support/:id/ticket',
    name: 'user-ticket-details',
    component: page('user/UserTicketsDetails.vue'),
  },
]

const AuthRoutes = [
  {
    path: '/login',
    name: 'login',
    component: page('auth/login.vue'),
  },
  {
    path: '/register',
    name: 'register',
    component: page('auth/register.vue'),
  },
  {
    path: '/password/request-reset',
    name: 'password.request',
    component: page('auth/password/request-email.vue'),
  },
  {
    path: '/password/reset/:token',
    name: 'password.reset',
    component: page('auth/password/reset.vue'),
  },
  {
    path: '/email/verify/:id',
    name: 'verification.verify',
    component: page('auth/verification/verify.vue'),
  },
  {
    path: '/email/resend',
    name: 'verification.resend',
    component: page('auth/verification/resend.vue'),
  },
  {
    path: '/email/verify-success',
    name: 'verification.verifySuccess',
    component: page('auth/verification/verifySuccess.vue'),
  },
  {
    path: '/email/verify-failure',
    name: 'verification.verifyFailure',
    component: page('auth/verification/verifyFailure.vue'),
  },
]

const routes = [
  ...AdminRoutes,
  ...UserRoutes,
  ...AuthRoutes,
  {
    path: '/',
    name: 'welcome',
    component: page('welcome.vue'),
  },
  {
    path: '/leaderboard',
    name: 'leaderboard',
    component: page('leaderboard.vue'),
  },
  {
    path: '/winners',
    name: 'winners',
    component: page('winners.vue'),
  },
  {
    path: '/live-games',
    name: 'live-games',
    component: page('liveGames.vue'),
  },
  {
    path: '/privacy-policy',
    name: 'privacy-policy',
    component: page('PrivacyPolicy.vue'),
  },
  {
    path: '/terms-and-conditions',
    name: 'terms-and-conditions',
    component: page('TermsAndConditions.vue'),
  },
  {
    name: 'game',
    path: '/game/:id?',
    component: page('game/_id.vue'),
  },
]

export function createRouter() {
  return new Router({
    routes,
    scrollBehavior,
    mode: 'history',
  })
}
