export const darkColor = '#363636';
export const chartColors = [
  '#d1108a', //rosa
  '#7d38bc', //violeta
  '#181c8b', //azul
  '#4290f0', //celeste
  '#3ab795', //verde
  '#f8e48c', //amarillo
  '#f06543', //naranja
  '#780116', //bordo

  '#d1108a', //rosa
  '#7d38bc', //violeta
  '#181c8b', //azul
  '#4290f0', //celeste
  '#3ab795', //verde
  '#f8e48c', //amarillo
  '#f06543', //naranja
  '#780116', //bordo
];
export const blankColor = '#d2ddff';

//# Contrast Color
export function getContrastColor(hexcolor) {
  hexcolor = hexcolor.replace('#', '');
  let contrast = parseInt(hexcolor, 16);
  return contrast > 0xffffff / 1.06 ? darkColor : '#fff';
}
