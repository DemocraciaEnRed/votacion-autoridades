export default function user_not_logged({ next, router }) {
  if (localStorage.getItem('user')) return router.push({ name: 'not-found' });

  return next();
}
