import chalk from 'chalk';

console.log(chalk.green.bold('\n✅ TailwindCSS compilé, démarrage de Laravel'));

const logo1 = [
  ' ____            _ ',
  '|  _ \\ __ _ _ __( )',
  '| |_) / _\` | \'__|/ ',
  '|  __/ (_| | |     ',
  '|_|   \\__,_|_|     '
];

const logo2 = [
  '  __  __ ___ _ ',
  ' |  \\/  |_ _( )',
  ' | |\\/| || ||/ ',
  ' | |  | || |   ',
  ' |_|  |_|___|  '
];

const logo3 = [
  '   ____ _                   ',
  '  / ___(_) __ _ _ __   ___  ',
  ' | |  _| |/ _\` | \'_ \\ / _ \\ ',
  ' | |_| | | (_| | | | | (_) |',
  '  \\____|_|\\__,_|_| |_|\\___/ '
];

const maxLines = Math.max(logo1.length, logo2.length, logo3.length);

let combined = '';
for (let i = 0; i < maxLines; i++) {
  const line1 = logo1[i] ? chalk.green(logo1[i]) : '';
  const line2 = logo2[i] ? chalk.white(logo2[i]) : '';
  const line3 = logo3[i] ? chalk.red(logo3[i]) : '';
  
  combined += line1.padEnd(25) + line2.padEnd(20) + line3 + '\n';
}

console.log(combined);