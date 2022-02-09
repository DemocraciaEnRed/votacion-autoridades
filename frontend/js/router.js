import Vue from 'vue';
import VueRouter from 'vue-router';

//# Middlewares
import user_logged from '@/js/middlewares/user_logged';
import user_not_logged from '@/js/middlewares/user_not_logged';
import user_voted from '@/js/middlewares/user_voted';
import user_not_voted from '@/js/middlewares/user_not_voted';

import voting_state_1 from '@/js/middlewares/voting_state_1';
import voting_state_2 from '@/js/middlewares/voting_state_2';
import voting_state_3 from '@/js/middlewares/voting_state_3';
import voting_state_4 from '@/js/middlewares/voting_state_4';

Vue.use(VueRouter);

const routes = [
  {
    name: 'home',
    path: '/',
    component: () => import('@/pages/home/Home'),
  },
  {
    name: 'about',
    path: '/nosotros',
    component: () => import('@/pages/About'),
  },
  //# Auth
  {
    name: 'roll-check',
    path: '/consultar-datos',
    component: () => import('@/pages/auth/rollCheck/RollCheck'),
    meta: {
      // Next() only if
      middleware: [user_not_logged, voting_state_1],
    },
  },
  {
    name: 'roll-request',
    path: '/solicitar-censo',
    component: () => import('@/pages/auth/rollRequest/RollRequest'),
    meta: {
      // Next() only if
      middleware: [user_not_logged, voting_state_1],
    },
  },
  {
    name: 'register',
    path: '/registrarse',
    component: () => import('@/pages/auth/register/Register'),
    meta: {
      // Next() only if
      middleware: [user_not_logged, voting_state_1],
    },
  },
  {
    name: 'login',
    path: '/iniciar-sesion',
    component: () => import('@/pages/auth/Login'),
    meta: {
      // Next() only if
      middleware: [user_not_logged],
    },
  },
  {
    name: 'profile',
    path: '/perfil',
    component: () => import('@/pages/auth/Profile'),
    meta: {
      // Next() only if
      middleware: [user_logged],
    },
  },
  //# End Auth
  {
    name: 'voting',
    path: '/votar',
    component: () => import('@/pages/voting/Voting'),
    meta: {
      // Next() only if
      middleware: [voting_state_2, user_logged, user_not_voted],
    },
  },
  {
    name: 'terms',
    path: '/terminos-condiciones',
    component: () => import('@/pages/Terms'),
  },
  {
    name: 'not-found',
    path: '*',
    component: () => import('@/pages/NotFound'),
  },
];

//# Init Router
const router = new VueRouter({
  mode: 'history',
  routes,
  scrollBehavior(to, from, savedPosition) {
    //# HASH
    if (to.hash) {
      const position = {
        selector: to.hash,
        behavior: 'smooth',
      };
      if (from.path == to.path) return position;

      window.scrollTo(0, 0);
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve(position);
        }, 700);
      });
    }
    //# N0 HASH
    else {
      window.scrollTo(0, 0);
    }
  },
});

//# Next Factory
function nextFactory(context, middleware, index) {
  const subsequentMiddleware = middleware[index];
  if (!subsequentMiddleware) return context.next;
  return (...parameters) => {
    context.next(...parameters);
    const nextMiddleware = nextFactory(context, middleware, index + 1);
    subsequentMiddleware({ ...context, next: nextMiddleware });
  };
}

router.beforeEach((to, from, next) => {
  if (to.meta.middleware) {
    const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];
    const context = {
      from,
      next,
      router,
      to,
    };
    const nextMiddleware = nextFactory(context, middleware, 1);
    return middleware[0]({ ...context, next: nextMiddleware });
  }
  return next();
});

export default router;
