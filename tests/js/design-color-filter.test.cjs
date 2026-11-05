const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const code = fs.readFileSync('public/assets/js/design.js', 'utf8');
const fn = code.slice(code.indexOf('function filterFrameColors('), code.indexOf('function applyInitialFrameDesign('));
const options = ['White', ' Black ', 'Gold'].map(color => ({ style: {}, getAttribute: () => color }));
const context = { currentFrameType: 'indian', document: { querySelectorAll: () => options } };
vm.createContext(context);
vm.runInContext(fn, context);
for (const design of ['classic-card-design', 'bold-card-design', 'frameless-card-design']) {
    context.filterFrameColors(design);
    assert.deepEqual(options.map(option => option.style.display), ['none', 'flex', 'none']);
}
context.currentFrameType = 'european';
context.filterFrameColors('classic-card-design');
assert(options.every(option => option.style.display === 'flex'));
context.filterFrameColors('frameless-card-design');
assert.deepEqual(options.map(option => option.style.display), ['flex', 'none', 'none']);
console.log('PASS: Indian black-only across designs; European colors and frameless behavior preserved');
