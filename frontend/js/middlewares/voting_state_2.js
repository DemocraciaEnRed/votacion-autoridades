export default function voting_state_2({ next, router }) {
  if (!localStorage.getItem('vote')) return router.push({ name: 'not-found' });

  const vote = JSON.parse(localStorage.getItem('vote'));
  if (vote.state_id != 2) return router.push({ name: 'not-found' });

  return next();
}