import fs from 'node:fs';
import path from 'node:path';

const projectRoot = process.cwd();
const componentPath = path.join(projectRoot, 'client', 'src', 'components', 'HolidayCalendar.tsx');
const cssAssetsDir = path.join(projectRoot, 'dist', 'public', 'assets');

function escapeForCssSelector(token) {
  // Escape characters used by Tailwind generated selectors
  return token.replace(/([!"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g, '\\$1');
}

function extractButtonClassTokens(source) {
  const start = source.indexOf('<button');
  if (start === -1) return [];

  const end = source.indexOf('</button>', start);
  if (end === -1) return [];

  const buttonBlock = source.slice(start, end);

  // Tangkap token class tailwind umum: bg-red-500, hover:bg-red-700, !text-white, ring-2, dll.
  const tokenRegex = /!?[a-z0-9-]+(?::[a-z0-9-]+)?(?:\/[a-z0-9.-]+)?(?:\[[^\]]+\])?/gi;
  const rawTokens = buttonBlock.match(tokenRegex) || [];

  return rawTokens.filter((t) => /^(bg|text|ring|hover:bg|hover:text|border)-|^!text-|^cursor-|^shadow-|^aspect-|^rounded-|^p-|^py-|^px-|^flex$|^flex-|^items-|^justify-|^relative$|^transition-|^duration-/.test(t));
}

function findBuiltCssFile() {
  if (!fs.existsSync(cssAssetsDir)) return null;
  const files = fs
    .readdirSync(cssAssetsDir)
    .filter((f) => f.endsWith('.css'))
    .map((f) => path.join(cssAssetsDir, f));

  if (files.length === 0) return null;

  files.sort((a, b) => fs.statSync(b).mtimeMs - fs.statSync(a).mtimeMs);
  return files[0];
}

if (!fs.existsSync(componentPath)) {
  console.error('File komponen tidak ditemukan:', componentPath);
  process.exit(1);
}

const source = fs.readFileSync(componentPath, 'utf8');
const tokens = extractButtonClassTokens(source);

const redTokens = [...new Set(tokens.filter((t) => t.includes('red-')))];
const cssFile = findBuiltCssFile();

if (!cssFile) {
  console.error('CSS build belum ditemukan di dist/public/assets. Jalankan `pnpm run build` dulu.');
  process.exit(1);
}

const css = fs.readFileSync(cssFile, 'utf8');

const report = redTokens.map((token) => {
  const escaped = escapeForCssSelector(token);
  const candidateSelectors = [
    `.${escaped}`,
    `.${escaped}:hover`,
    `.${escaped}:focus`,
    `.${escaped}:active`,
  ];

  const foundBySelector = candidateSelectors.some((s) => css.includes(s));

  // fallback longgar untuk kasus minified kompleks
  const looseNeedle = token.replace(/^!/, '').replace(/^hover:/, '').replace(/^focus:/, '').replace(/^active:/, '');
  const foundLoose = css.includes(looseNeedle);

  return {
    token,
    found: foundBySelector || foundLoose,
    via: foundBySelector ? 'selector' : foundLoose ? 'loose' : 'none',
  };
});

console.log('=== Audit Tailwind Red Classes ===');
console.log('Component :', path.relative(projectRoot, componentPath));
console.log('CSS Build :', path.relative(projectRoot, cssFile));
console.log('');

for (const row of report) {
  const mark = row.found ? '✅' : '❌';
  console.log(`${mark} ${row.token}  [${row.via}]`);
}

const missing = report.filter((r) => !r.found);
console.log('');
console.log('Ringkasan:', `${report.length - missing.length}/${report.length} token merah terdeteksi di CSS build.`);
if (missing.length > 0) {
  console.log('Tidak terdeteksi:', missing.map((m) => m.token).join(', '));
}
