export default function user_logged({ next, router }) {
  if (!localStorage.getItem('user')) return router.push({ name: 'not-found' });

  return next();
}
