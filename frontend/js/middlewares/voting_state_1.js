export default function voting_state_1({ next, router }) {
  if (!localStorage.getItem('vote')) return router.push({ name: 'not-found' });

  const vote = JSON.parse(localStorage.getItem('vote'));
  if (vote.state_id != 1) return router.push({ name: 'not-found' });

  return next();
}
