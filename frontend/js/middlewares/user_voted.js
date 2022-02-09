export default function user_voted({ next, router }) {
  const user = JSON.parse(localStorage.getItem('user'));
  if (!user.vote) return router.push({ name: 'not-found' });

  return next();
}
