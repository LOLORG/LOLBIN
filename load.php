<?php

define("SQL_SERVER", "127.0.0.1");
define("SQL_DATABASE", "lolbin");
define("SQL_USERNAME", "root");
define("SQL_PASSWORD", "ZingoRingo00");

if (!$_GET["delete"]) {
	$paste = "";

	try {
		$conn = new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT * FROM pastes WHERE id = :id");
		$stmt->bindParam(":id", $_GET["id"]);
		$stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) < 1) {
			echo "no";
			die();
		} else {
			$paste = $results[0]["content"];
		}
	} catch (PDOException $e) {
		echo '500!!!! WAAAAT!!!!!';
		die();
	}
} else {
	try {
		$conn = new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT * FROM pastes WHERE id = :id AND user_token = :token");
		$stmt->bindParam(":id", $_GET["id"]);
		$stmt->bindParam(":token", $_COOKIE["token"]);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($results) < 1) {
			echo "no";
			die();
		}

		$conn = new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("DELETE FROM pastes WHERE id = :id AND user_token = :token");
		$stmt->bindParam(":id", $_GET["id"]);
		$stmt->bindParam(":token", $_COOKIE["token"]);
		$stmt->execute();
		echo "k";
		die();
	} catch (PDOException $e) {
		echo '500!!!! WAAAAT!!!!!';
		die();
	}
}

?>
<!DOCTYPE html><html manifest="load.appcache"><head><meta charset=UTF-8><meta name=viewport content="width=device-width,minimum-scale=1,initial-scale=1"/><meta name=language content=EN><meta name=keywords content="code, codebase, snippet, snippets, codebottle, paste, pastebin, function, class, search"><title>LOLBIN</title><style>body{padding:8px;color:white;background:#222;text-align:right;font-family:Consolas,monospace}h1{font-size:5em}#del-btn{padding:8px 12px;background:#c50000;font-weight:900;border:0;border-radius:4px;color:white}pre code{border:1px solid gray;padding:16px !important;}#container{text-align:left}.hljs{display:block;overflow-x:auto;padding:.5em;background:#23241f}.hljs,.hljs-tag,.hljs-subst{color:#f8f8f2}.hljs-strong,.hljs-emphasis{color:#a8a8a2}.hljs-bullet,.hljs-quote,.hljs-number,.hljs-regexp,.hljs-literal,.hljs-link{color:#ae81ff}.hljs-code,.hljs-title,.hljs-section,.hljs-selector-class{color:#a6e22e}.hljs-strong{font-weight:bold}.hljs-emphasis{font-style:italic}.hljs-keyword,.hljs-selector-tag,.hljs-name,.hljs-attr{color:#f92672}.hljs-symbol,.hljs-attribute{color:#66d9ef}.hljs-params,.hljs-class .hljs-title{color:#f8f8f2}.hljs-string,.hljs-type,.hljs-built_in,.hljs-builtin-name,.hljs-selector-id,.hljs-selector-attr,.hljs-selector-pseudo,.hljs-addition,.hljs-variable,.hljs-template-variable{color:#e6db74}.hljs-comment,.hljs-deletion,.hljs-meta{color:#75715e}</style><script>
(function(factory) {

// Find the global object for export to both the browser and web workers.
var globalObject = typeof window === 'object' && window ||
typeof self === 'object' && self;

// Setup highlight.js for different environments. First is Node.js or
// CommonJS.
if(typeof exports !== 'undefined') {
factory(exports);
} else if(globalObject) {
// Export hljs globally even when using AMD for cases when this script
// is loaded with others that may still expect a global hljs.
globalObject.hljs = factory({});

// Finally register the global hljs with AMD.
if(typeof define === 'function' && define.amd) {
define([], function() {
return globalObject.hljs;
});
}
}

}(function(hljs) {
// Convenience variables for build-in objects
var ArrayProto = [],
objectKeys = Object.keys;

// Global internal variables used within the highlight.js library.
var languages = {},
aliases   = {};

// Regular expressions used throughout the highlight.js library.
var noHighlightRe    = /^(no-?highlight|plain|text)$/i,
languagePrefixRe = /\blang(?:uage)?-([\w-]+)\b/i,
fixMarkupRe      = /((^(<[^>]+>|\t|)+|(?:\n)))/gm;

var spanEndTag = '</span>';

// Global options used when within external APIs. This is modified when
// calling the `hljs.configure` function.
var options = {
classPrefix: 'hljs-',
tabReplace: null,
useBR: false,
languages: undefined
};

// Object map that is used to escape some common HTML characters.
var escapeRegexMap = {
'&': '&amp;',
'<': '&lt;',
'>': '&gt;'
};

/* Utility functions */

function escape(value) {
return value.replace(/[&<>]/gm, function(character) {
return escapeRegexMap[character];
});
}

function tag(node) {
return node.nodeName.toLowerCase();
}

function testRe(re, lexeme) {
var match = re && re.exec(lexeme);
return match && match.index === 0;
}

function isNotHighlighted(language) {
return noHighlightRe.test(language);
}

function blockLanguage(block) {
var i, match, length, _class;
var classes = block.className + ' ';

classes += block.parentNode ? block.parentNode.className : '';

// language-* takes precedence over non-prefixed class names.
match = languagePrefixRe.exec(classes);
if (match) {
return getLanguage(match[1]) ? match[1] : 'no-highlight';
}

classes = classes.split(/\s+/);

for (i = 0, length = classes.length; i < length; i++) {
_class = classes[i]

if (isNotHighlighted(_class) || getLanguage(_class)) {
return _class;
}
}
}

function inherit(parent, obj) {
var key;
var result = {};

for (key in parent)
result[key] = parent[key];
if (obj)
for (key in obj)
result[key] = obj[key];
return result;
}

/* Stream merging */

function nodeStream(node) {
var result = [];
(function _nodeStream(node, offset) {
for (var child = node.firstChild; child; child = child.nextSibling) {
if (child.nodeType === 3)
offset += child.nodeValue.length;
else if (child.nodeType === 1) {
result.push({
event: 'start',
offset: offset,
node: child
});
offset = _nodeStream(child, offset);
// Prevent void elements from having an end tag that would actually
// double them in the output. There are more void elements in HTML
// but we list only those realistically expected in code display.
if (!tag(child).match(/br|hr|img|input/)) {
result.push({
event: 'stop',
offset: offset,
node: child
});
}
}
}
return offset;
})(node, 0);
return result;
}

function mergeStreams(original, highlighted, value) {
var processed = 0;
var result = '';
var nodeStack = [];

function selectStream() {
if (!original.length || !highlighted.length) {
return original.length ? original : highlighted;
}
if (original[0].offset !== highlighted[0].offset) {
return (original[0].offset < highlighted[0].offset) ? original : highlighted;
}

/*
To avoid starting the stream just before it should stop the order is
ensured that original always starts first and closes last:

if (event1 == 'start' && event2 == 'start')
return original;
if (event1 == 'start' && event2 == 'stop')
return highlighted;
if (event1 == 'stop' && event2 == 'start')
return original;
if (event1 == 'stop' && event2 == 'stop')
return highlighted;

... which is collapsed to:
*/
return highlighted[0].event === 'start' ? original : highlighted;
}

function open(node) {
function attr_str(a) {return ' ' + a.nodeName + '="' + escape(a.value) + '"';}
result += '<' + tag(node) + ArrayProto.map.call(node.attributes, attr_str).join('') + '>';
}

function close(node) {
result += '</' + tag(node) + '>';
}

function render(event) {
(event.event === 'start' ? open : close)(event.node);
}

while (original.length || highlighted.length) {
var stream = selectStream();
result += escape(value.substr(processed, stream[0].offset - processed));
processed = stream[0].offset;
if (stream === original) {
/*
On any opening or closing tag of the original markup we first close
the entire highlighted node stack, then render the original tag along
with all the following original tags at the same offset and then
reopen all the tags on the highlighted stack.
*/
nodeStack.reverse().forEach(close);
do {
render(stream.splice(0, 1)[0]);
stream = selectStream();
} while (stream === original && stream.length && stream[0].offset === processed);
nodeStack.reverse().forEach(open);
} else {
if (stream[0].event === 'start') {
nodeStack.push(stream[0].node);
} else {
nodeStack.pop();
}
render(stream.splice(0, 1)[0]);
}
}
return result + escape(value.substr(processed));
}

/* Initialization */

function compileLanguage(language) {

function reStr(re) {
return (re && re.source) || re;
}

function langRe(value, global) {
return new RegExp(
reStr(value),
'm' + (language.case_insensitive ? 'i' : '') + (global ? 'g' : '')
);
}

function compileMode(mode, parent) {
if (mode.compiled)
return;
mode.compiled = true;

mode.keywords = mode.keywords || mode.beginKeywords;
if (mode.keywords) {
var compiled_keywords = {};

var flatten = function(className, str) {
if (language.case_insensitive) {
str = str.toLowerCase();
}
str.split(' ').forEach(function(kw) {
var pair = kw.split('|');
compiled_keywords[pair[0]] = [className, pair[1] ? Number(pair[1]) : 1];
});
};

if (typeof mode.keywords === 'string') { // string
flatten('keyword', mode.keywords);
} else {
objectKeys(mode.keywords).forEach(function (className) {
flatten(className, mode.keywords[className]);
});
}
mode.keywords = compiled_keywords;
}
mode.lexemesRe = langRe(mode.lexemes || /\w+/, true);

if (parent) {
if (mode.beginKeywords) {
mode.begin = '\\b(' + mode.beginKeywords.split(' ').join('|') + ')\\b';
}
if (!mode.begin)
mode.begin = /\B|\b/;
mode.beginRe = langRe(mode.begin);
if (!mode.end && !mode.endsWithParent)
mode.end = /\B|\b/;
if (mode.end)
mode.endRe = langRe(mode.end);
mode.terminator_end = reStr(mode.end) || '';
if (mode.endsWithParent && parent.terminator_end)
mode.terminator_end += (mode.end ? '|' : '') + parent.terminator_end;
}
if (mode.illegal)
mode.illegalRe = langRe(mode.illegal);
if (mode.relevance == null)
mode.relevance = 1;
if (!mode.contains) {
mode.contains = [];
}
var expanded_contains = [];
mode.contains.forEach(function(c) {
if (c.variants) {
c.variants.forEach(function(v) {expanded_contains.push(inherit(c, v));});
} else {
expanded_contains.push(c === 'self' ? mode : c);
}
});
mode.contains = expanded_contains;
mode.contains.forEach(function(c) {compileMode(c, mode);});

if (mode.starts) {
compileMode(mode.starts, parent);
}

var terminators =
mode.contains.map(function(c) {
return c.beginKeywords ? '\\.?(' + c.begin + ')\\.?' : c.begin;
})
.concat([mode.terminator_end, mode.illegal])
.map(reStr)
.filter(Boolean);
mode.terminators = terminators.length ? langRe(terminators.join('|'), true) : {exec: function(/*s*/) {return null;}};
}

compileMode(language);
}

/*
Core highlighting function. Accepts a language name, or an alias, and a
string with the code to highlight. Returns an object with the following
properties:

- relevance (int)
- value (an HTML string with highlighting markup)

*/
function highlight(name, value, ignore_illegals, continuation) {

function subMode(lexeme, mode) {
var i, length;

for (i = 0, length = mode.contains.length; i < length; i++) {
if (testRe(mode.contains[i].beginRe, lexeme)) {
return mode.contains[i];
}
}
}

function endOfMode(mode, lexeme) {
if (testRe(mode.endRe, lexeme)) {
while (mode.endsParent && mode.parent) {
mode = mode.parent;
}
return mode;
}
if (mode.endsWithParent) {
return endOfMode(mode.parent, lexeme);
}
}

function isIllegal(lexeme, mode) {
return !ignore_illegals && testRe(mode.illegalRe, lexeme);
}

function keywordMatch(mode, match) {
var match_str = language.case_insensitive ? match[0].toLowerCase() : match[0];
return mode.keywords.hasOwnProperty(match_str) && mode.keywords[match_str];
}

function buildSpan(classname, insideSpan, leaveOpen, noPrefix) {
var classPrefix = noPrefix ? '' : options.classPrefix,
openSpan    = '<span class="' + classPrefix,
closeSpan   = leaveOpen ? '' : spanEndTag

openSpan += classname + '">';

return openSpan + insideSpan + closeSpan;
}

function processKeywords() {
var keyword_match, last_index, match, result;

if (!top.keywords)
return escape(mode_buffer);

result = '';
last_index = 0;
top.lexemesRe.lastIndex = 0;
match = top.lexemesRe.exec(mode_buffer);

while (match) {
result += escape(mode_buffer.substr(last_index, match.index - last_index));
keyword_match = keywordMatch(top, match);
if (keyword_match) {
relevance += keyword_match[1];
result += buildSpan(keyword_match[0], escape(match[0]));
} else {
result += escape(match[0]);
}
last_index = top.lexemesRe.lastIndex;
match = top.lexemesRe.exec(mode_buffer);
}
return result + escape(mode_buffer.substr(last_index));
}

function processSubLanguage() {
var explicit = typeof top.subLanguage === 'string';
if (explicit && !languages[top.subLanguage]) {
return escape(mode_buffer);
}

var result = explicit ?
highlight(top.subLanguage, mode_buffer, true, continuations[top.subLanguage]) :
highlightAuto(mode_buffer, top.subLanguage.length ? top.subLanguage : undefined);

// Counting embedded language score towards the host language may be disabled
// with zeroing the containing mode relevance. Usecase in point is Markdown that
// allows XML everywhere and makes every XML snippet to have a much larger Markdown
// score.
if (top.relevance > 0) {
relevance += result.relevance;
}
if (explicit) {
continuations[top.subLanguage] = result.top;
}
return buildSpan(result.language, result.value, false, true);
}

function processBuffer() {
result += (top.subLanguage != null ? processSubLanguage() : processKeywords());
mode_buffer = '';
}

function startNewMode(mode) {
result += mode.className? buildSpan(mode.className, '', true): '';
top = Object.create(mode, {parent: {value: top}});
}

function processLexeme(buffer, lexeme) {

mode_buffer += buffer;

if (lexeme == null) {
processBuffer();
return 0;
}

var new_mode = subMode(lexeme, top);
if (new_mode) {
if (new_mode.skip) {
mode_buffer += lexeme;
} else {
if (new_mode.excludeBegin) {
mode_buffer += lexeme;
}
processBuffer();
if (!new_mode.returnBegin && !new_mode.excludeBegin) {
mode_buffer = lexeme;
}
}
startNewMode(new_mode, lexeme);
return new_mode.returnBegin ? 0 : lexeme.length;
}

var end_mode = endOfMode(top, lexeme);
if (end_mode) {
var origin = top;
if (origin.skip) {
mode_buffer += lexeme;
} else {
if (!(origin.returnEnd || origin.excludeEnd)) {
mode_buffer += lexeme;
}
processBuffer();
if (origin.excludeEnd) {
mode_buffer = lexeme;
}
}
do {
if (top.className) {
result += spanEndTag;
}
if (!top.skip) {
relevance += top.relevance;
}
top = top.parent;
} while (top !== end_mode.parent);
if (end_mode.starts) {
startNewMode(end_mode.starts, '');
}
return origin.returnEnd ? 0 : lexeme.length;
}

if (isIllegal(lexeme, top))
throw new Error('Illegal lexeme "' + lexeme + '" for mode "' + (top.className || '<unnamed>') + '"');

/*
Parser should not reach this point as all types of lexemes should be caught
earlier, but if it does due to some bug make sure it advances at least one
character forward to prevent infinite looping.
*/
mode_buffer += lexeme;
return lexeme.length || 1;
}

var language = getLanguage(name);
if (!language) {
throw new Error('Unknown language: "' + name + '"');
}

compileLanguage(language);
var top = continuation || language;
var continuations = {}; // keep continuations for sub-languages
var result = '', current;
for(current = top; current !== language; current = current.parent) {
if (current.className) {
result = buildSpan(current.className, '', true) + result;
}
}
var mode_buffer = '';
var relevance = 0;
try {
var match, count, index = 0;
while (true) {
top.terminators.lastIndex = index;
match = top.terminators.exec(value);
if (!match)
break;
count = processLexeme(value.substr(index, match.index - index), match[0]);
index = match.index + count;
}
processLexeme(value.substr(index));
for(current = top; current.parent; current = current.parent) { // close dangling modes
if (current.className) {
result += spanEndTag;
}
}
return {
relevance: relevance,
value: result,
language: name,
top: top
};
} catch (e) {
if (e.message && e.message.indexOf('Illegal') !== -1) {
return {
relevance: 0,
value: escape(value)
};
} else {
throw e;
}
}
}

/*
Highlighting with language detection. Accepts a string with the code to
highlight. Returns an object with the following properties:

- language (detected language)
- relevance (int)
- value (an HTML string with highlighting markup)
- second_best (object with the same structure for second-best heuristically
detected language, may be absent)

*/
function highlightAuto(text, languageSubset) {
languageSubset = languageSubset || options.languages || objectKeys(languages);
var result = {
relevance: 0,
value: escape(text)
};
var second_best = result;
languageSubset.filter(getLanguage).forEach(function(name) {
var current = highlight(name, text, false);
current.language = name;
if (current.relevance > second_best.relevance) {
second_best = current;
}
if (current.relevance > result.relevance) {
second_best = result;
result = current;
}
});
if (second_best.language) {
result.second_best = second_best;
}
return result;
}

/*
Post-processing of the highlighted markup:

- replace TABs with something more useful
- replace real line-breaks with '<br>' for non-pre containers

*/
function fixMarkup(value) {
return !(options.tabReplace || options.useBR)
? value
: value.replace(fixMarkupRe, function(match, p1) {
if (options.useBR && match === '\n') {
return '<br>';
} else if (options.tabReplace) {
return p1.replace(/\t/g, options.tabReplace);
}
});
}

function buildClassName(prevClassName, currentLang, resultLang) {
var language = currentLang ? aliases[currentLang] : resultLang,
result   = [prevClassName.trim()];

if (!prevClassName.match(/\bhljs\b/)) {
result.push('hljs');
}

if (prevClassName.indexOf(language) === -1) {
result.push(language);
}

return result.join(' ').trim();
}

/*
Applies highlighting to a DOM node containing code. Accepts a DOM node and
two optional parameters for fixMarkup.
*/
function highlightBlock(block) {
var node, originalStream, result, resultNode, text;
var language = blockLanguage(block);

if (isNotHighlighted(language))
return;

if (options.useBR) {
node = document.createElementNS('http://www.w3.org/1999/xhtml', 'div');
node.innerHTML = block.innerHTML.replace(/\n/g, '').replace(/<br[ \/]*>/g, '\n');
} else {
node = block;
}
text = node.textContent;
result = language ? highlight(language, text, true) : highlightAuto(text);

originalStream = nodeStream(node);
if (originalStream.length) {
resultNode = document.createElementNS('http://www.w3.org/1999/xhtml', 'div');
resultNode.innerHTML = result.value;
result.value = mergeStreams(originalStream, nodeStream(resultNode), text);
}
result.value = fixMarkup(result.value);

block.innerHTML = result.value;
block.className = buildClassName(block.className, language, result.language);
block.result = {
language: result.language,
re: result.relevance
};
if (result.second_best) {
block.second_best = {
language: result.second_best.language,
re: result.second_best.relevance
};
}
}

/*
Updates highlight.js global options with values passed in the form of an object.
*/
function configure(user_options) {
options = inherit(options, user_options);
}

/*
Applies highlighting to all <pre><code>..</code></pre> blocks on a page.
*/
function initHighlighting() {
if (initHighlighting.called)
return;
initHighlighting.called = true;

var blocks = document.querySelectorAll('pre code');
ArrayProto.forEach.call(blocks, highlightBlock);
}

/*
Attaches highlighting to the page load event.
*/
function initHighlightingOnLoad() {
addEventListener('DOMContentLoaded', initHighlighting, false);
addEventListener('load', initHighlighting, false);
}

function registerLanguage(name, language) {
var lang = languages[name] = language(hljs);
if (lang.aliases) {
lang.aliases.forEach(function(alias) {aliases[alias] = name;});
}
}

function listLanguages() {
return objectKeys(languages);
}

function getLanguage(name) {
name = (name || '').toLowerCase();
return languages[name] || languages[aliases[name]];
}

/* Interface definition */

hljs.highlight = highlight;
hljs.highlightAuto = highlightAuto;
hljs.fixMarkup = fixMarkup;
hljs.highlightBlock = highlightBlock;
hljs.configure = configure;
hljs.initHighlighting = initHighlighting;
hljs.initHighlightingOnLoad = initHighlightingOnLoad;
hljs.registerLanguage = registerLanguage;
hljs.listLanguages = listLanguages;
hljs.getLanguage = getLanguage;
hljs.inherit = inherit;

// Common regexps
hljs.IDENT_RE = '[a-zA-Z]\\w*';
hljs.UNDERSCORE_IDENT_RE = '[a-zA-Z_]\\w*';
hljs.NUMBER_RE = '\\b\\d+(\\.\\d+)?';
hljs.C_NUMBER_RE = '(-?)(\\b0[xX][a-fA-F0-9]+|(\\b\\d+(\\.\\d*)?|\\.\\d+)([eE][-+]?\\d+)?)'; // 0x..., 0..., decimal, float
hljs.BINARY_NUMBER_RE = '\\b(0b[01]+)'; // 0b...
hljs.RE_STARTERS_RE = '!|!=|!==|%|%=|&|&&|&=|\\*|\\*=|\\+|\\+=|,|-|-=|/=|/|:|;|<<|<<=|<=|<|===|==|=|>>>=|>>=|>=|>>>|>>|>|\\?|\\[|\\{|\\(|\\^|\\^=|\\||\\|=|\\|\\||~';

// Common modes
hljs.BACKSLASH_ESCAPE = {
begin: '\\\\[\\s\\S]', relevance: 0
};
hljs.APOS_STRING_MODE = {
className: 'string',
begin: '\'', end: '\'',
illegal: '\\n',
contains: [hljs.BACKSLASH_ESCAPE]
};
hljs.QUOTE_STRING_MODE = {
className: 'string',
begin: '"', end: '"',
illegal: '\\n',
contains: [hljs.BACKSLASH_ESCAPE]
};
hljs.PHRASAL_WORDS_MODE = {
begin: /\b(a|an|the|are|I'm|isn't|don't|doesn't|won't|but|just|should|pretty|simply|enough|gonna|going|wtf|so|such|will|you|your|like)\b/
};
hljs.COMMENT = function (begin, end, inherits) {
var mode = hljs.inherit(
{
className: 'comment',
begin: begin, end: end,
contains: []
},
inherits || {}
);
mode.contains.push(hljs.PHRASAL_WORDS_MODE);
mode.contains.push({
className: 'doctag',
begin: '(?:TODO|FIXME|NOTE|BUG|XXX):',
relevance: 0
});
return mode;
};
hljs.C_LINE_COMMENT_MODE = hljs.COMMENT('//', '$');
hljs.C_BLOCK_COMMENT_MODE = hljs.COMMENT('/\\*', '\\*/');
hljs.HASH_COMMENT_MODE = hljs.COMMENT('#', '$');
hljs.NUMBER_MODE = {
className: 'number',
begin: hljs.NUMBER_RE,
relevance: 0
};
hljs.C_NUMBER_MODE = {
className: 'number',
begin: hljs.C_NUMBER_RE,
relevance: 0
};
hljs.BINARY_NUMBER_MODE = {
className: 'number',
begin: hljs.BINARY_NUMBER_RE,
relevance: 0
};
hljs.CSS_NUMBER_MODE = {
className: 'number',
begin: hljs.NUMBER_RE + '(' +
'%|em|ex|ch|rem'  +
'|vw|vh|vmin|vmax' +
'|cm|mm|in|pt|pc|px' +
'|deg|grad|rad|turn' +
'|s|ms' +
'|Hz|kHz' +
'|dpi|dpcm|dppx' +
')?',
relevance: 0
};
hljs.REGEXP_MODE = {
className: 'regexp',
begin: /\//, end: /\/[gimuy]*/,
illegal: /\n/,
contains: [
hljs.BACKSLASH_ESCAPE,
{
begin: /\[/, end: /\]/,
relevance: 0,
contains: [hljs.BACKSLASH_ESCAPE]
}
]
};
hljs.TITLE_MODE = {
className: 'title',
begin: hljs.IDENT_RE,
relevance: 0
};
hljs.UNDERSCORE_TITLE_MODE = {
className: 'title',
begin: hljs.UNDERSCORE_IDENT_RE,
relevance: 0
};
hljs.METHOD_GUARD = {
// excludes method names from keyword processing
begin: '\\.\\s*' + hljs.UNDERSCORE_IDENT_RE,
relevance: 0
};

return hljs;
}));

/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
var CryptoJS=CryptoJS||function(u,p){var d={},l=d.lib={},s=function(){},t=l.Base={extend:function(a){s.prototype=this;var c=new s;a&&c.mixIn(a);c.hasOwnProperty("init")||(c.init=function(){c.$super.init.apply(this,arguments)});c.init.prototype=c;c.$super=this;return c},create:function(){var a=this.extend();a.init.apply(a,arguments);return a},init:function(){},mixIn:function(a){for(var c in a)a.hasOwnProperty(c)&&(this[c]=a[c]);a.hasOwnProperty("toString")&&(this.toString=a.toString)},clone:function(){return this.init.prototype.extend(this)}},
r=l.WordArray=t.extend({init:function(a,c){a=this.words=a||[];this.sigBytes=c!=p?c:4*a.length},toString:function(a){return(a||v).stringify(this)},concat:function(a){var c=this.words,e=a.words,j=this.sigBytes;a=a.sigBytes;this.clamp();if(j%4)for(var k=0;k<a;k++)c[j+k>>>2]|=(e[k>>>2]>>>24-8*(k%4)&255)<<24-8*((j+k)%4);else if(65535<e.length)for(k=0;k<a;k+=4)c[j+k>>>2]=e[k>>>2];else c.push.apply(c,e);this.sigBytes+=a;return this},clamp:function(){var a=this.words,c=this.sigBytes;a[c>>>2]&=4294967295<<
32-8*(c%4);a.length=u.ceil(c/4)},clone:function(){var a=t.clone.call(this);a.words=this.words.slice(0);return a},random:function(a){for(var c=[],e=0;e<a;e+=4)c.push(4294967296*u.random()|0);return new r.init(c,a)}}),w=d.enc={},v=w.Hex={stringify:function(a){var c=a.words;a=a.sigBytes;for(var e=[],j=0;j<a;j++){var k=c[j>>>2]>>>24-8*(j%4)&255;e.push((k>>>4).toString(16));e.push((k&15).toString(16))}return e.join("")},parse:function(a){for(var c=a.length,e=[],j=0;j<c;j+=2)e[j>>>3]|=parseInt(a.substr(j,
2),16)<<24-4*(j%8);return new r.init(e,c/2)}},b=w.Latin1={stringify:function(a){var c=a.words;a=a.sigBytes;for(var e=[],j=0;j<a;j++)e.push(String.fromCharCode(c[j>>>2]>>>24-8*(j%4)&255));return e.join("")},parse:function(a){for(var c=a.length,e=[],j=0;j<c;j++)e[j>>>2]|=(a.charCodeAt(j)&255)<<24-8*(j%4);return new r.init(e,c)}},x=w.Utf8={stringify:function(a){try{return decodeURIComponent(escape(b.stringify(a)))}catch(c){throw Error("Malformed UTF-8 data");}},parse:function(a){return b.parse(unescape(encodeURIComponent(a)))}},
q=l.BufferedBlockAlgorithm=t.extend({reset:function(){this._data=new r.init;this._nDataBytes=0},_append:function(a){"string"==typeof a&&(a=x.parse(a));this._data.concat(a);this._nDataBytes+=a.sigBytes},_process:function(a){var c=this._data,e=c.words,j=c.sigBytes,k=this.blockSize,b=j/(4*k),b=a?u.ceil(b):u.max((b|0)-this._minBufferSize,0);a=b*k;j=u.min(4*a,j);if(a){for(var q=0;q<a;q+=k)this._doProcessBlock(e,q);q=e.splice(0,a);c.sigBytes-=j}return new r.init(q,j)},clone:function(){var a=t.clone.call(this);
a._data=this._data.clone();return a},_minBufferSize:0});l.Hasher=q.extend({cfg:t.extend(),init:function(a){this.cfg=this.cfg.extend(a);this.reset()},reset:function(){q.reset.call(this);this._doReset()},update:function(a){this._append(a);this._process();return this},finalize:function(a){a&&this._append(a);return this._doFinalize()},blockSize:16,_createHelper:function(a){return function(b,e){return(new a.init(e)).finalize(b)}},_createHmacHelper:function(a){return function(b,e){return(new n.HMAC.init(a,
e)).finalize(b)}}});var n=d.algo={};return d}(Math);
(function(){var u=CryptoJS,p=u.lib.WordArray;u.enc.Base64={stringify:function(d){var l=d.words,p=d.sigBytes,t=this._map;d.clamp();d=[];for(var r=0;r<p;r+=3)for(var w=(l[r>>>2]>>>24-8*(r%4)&255)<<16|(l[r+1>>>2]>>>24-8*((r+1)%4)&255)<<8|l[r+2>>>2]>>>24-8*((r+2)%4)&255,v=0;4>v&&r+0.75*v<p;v++)d.push(t.charAt(w>>>6*(3-v)&63));if(l=t.charAt(64))for(;d.length%4;)d.push(l);return d.join("")},parse:function(d){var l=d.length,s=this._map,t=s.charAt(64);t&&(t=d.indexOf(t),-1!=t&&(l=t));for(var t=[],r=0,w=0;w<
l;w++)if(w%4){var v=s.indexOf(d.charAt(w-1))<<2*(w%4),b=s.indexOf(d.charAt(w))>>>6-2*(w%4);t[r>>>2]|=(v|b)<<24-8*(r%4);r++}return p.create(t,r)},_map:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="}})();
(function(u){function p(b,n,a,c,e,j,k){b=b+(n&a|~n&c)+e+k;return(b<<j|b>>>32-j)+n}function d(b,n,a,c,e,j,k){b=b+(n&c|a&~c)+e+k;return(b<<j|b>>>32-j)+n}function l(b,n,a,c,e,j,k){b=b+(n^a^c)+e+k;return(b<<j|b>>>32-j)+n}function s(b,n,a,c,e,j,k){b=b+(a^(n|~c))+e+k;return(b<<j|b>>>32-j)+n}for(var t=CryptoJS,r=t.lib,w=r.WordArray,v=r.Hasher,r=t.algo,b=[],x=0;64>x;x++)b[x]=4294967296*u.abs(u.sin(x+1))|0;r=r.MD5=v.extend({_doReset:function(){this._hash=new w.init([1732584193,4023233417,2562383102,271733878])},
_doProcessBlock:function(q,n){for(var a=0;16>a;a++){var c=n+a,e=q[c];q[c]=(e<<8|e>>>24)&16711935|(e<<24|e>>>8)&4278255360}var a=this._hash.words,c=q[n+0],e=q[n+1],j=q[n+2],k=q[n+3],z=q[n+4],r=q[n+5],t=q[n+6],w=q[n+7],v=q[n+8],A=q[n+9],B=q[n+10],C=q[n+11],u=q[n+12],D=q[n+13],E=q[n+14],x=q[n+15],f=a[0],m=a[1],g=a[2],h=a[3],f=p(f,m,g,h,c,7,b[0]),h=p(h,f,m,g,e,12,b[1]),g=p(g,h,f,m,j,17,b[2]),m=p(m,g,h,f,k,22,b[3]),f=p(f,m,g,h,z,7,b[4]),h=p(h,f,m,g,r,12,b[5]),g=p(g,h,f,m,t,17,b[6]),m=p(m,g,h,f,w,22,b[7]),
f=p(f,m,g,h,v,7,b[8]),h=p(h,f,m,g,A,12,b[9]),g=p(g,h,f,m,B,17,b[10]),m=p(m,g,h,f,C,22,b[11]),f=p(f,m,g,h,u,7,b[12]),h=p(h,f,m,g,D,12,b[13]),g=p(g,h,f,m,E,17,b[14]),m=p(m,g,h,f,x,22,b[15]),f=d(f,m,g,h,e,5,b[16]),h=d(h,f,m,g,t,9,b[17]),g=d(g,h,f,m,C,14,b[18]),m=d(m,g,h,f,c,20,b[19]),f=d(f,m,g,h,r,5,b[20]),h=d(h,f,m,g,B,9,b[21]),g=d(g,h,f,m,x,14,b[22]),m=d(m,g,h,f,z,20,b[23]),f=d(f,m,g,h,A,5,b[24]),h=d(h,f,m,g,E,9,b[25]),g=d(g,h,f,m,k,14,b[26]),m=d(m,g,h,f,v,20,b[27]),f=d(f,m,g,h,D,5,b[28]),h=d(h,f,
m,g,j,9,b[29]),g=d(g,h,f,m,w,14,b[30]),m=d(m,g,h,f,u,20,b[31]),f=l(f,m,g,h,r,4,b[32]),h=l(h,f,m,g,v,11,b[33]),g=l(g,h,f,m,C,16,b[34]),m=l(m,g,h,f,E,23,b[35]),f=l(f,m,g,h,e,4,b[36]),h=l(h,f,m,g,z,11,b[37]),g=l(g,h,f,m,w,16,b[38]),m=l(m,g,h,f,B,23,b[39]),f=l(f,m,g,h,D,4,b[40]),h=l(h,f,m,g,c,11,b[41]),g=l(g,h,f,m,k,16,b[42]),m=l(m,g,h,f,t,23,b[43]),f=l(f,m,g,h,A,4,b[44]),h=l(h,f,m,g,u,11,b[45]),g=l(g,h,f,m,x,16,b[46]),m=l(m,g,h,f,j,23,b[47]),f=s(f,m,g,h,c,6,b[48]),h=s(h,f,m,g,w,10,b[49]),g=s(g,h,f,m,
E,15,b[50]),m=s(m,g,h,f,r,21,b[51]),f=s(f,m,g,h,u,6,b[52]),h=s(h,f,m,g,k,10,b[53]),g=s(g,h,f,m,B,15,b[54]),m=s(m,g,h,f,e,21,b[55]),f=s(f,m,g,h,v,6,b[56]),h=s(h,f,m,g,x,10,b[57]),g=s(g,h,f,m,t,15,b[58]),m=s(m,g,h,f,D,21,b[59]),f=s(f,m,g,h,z,6,b[60]),h=s(h,f,m,g,C,10,b[61]),g=s(g,h,f,m,j,15,b[62]),m=s(m,g,h,f,A,21,b[63]);a[0]=a[0]+f|0;a[1]=a[1]+m|0;a[2]=a[2]+g|0;a[3]=a[3]+h|0},_doFinalize:function(){var b=this._data,n=b.words,a=8*this._nDataBytes,c=8*b.sigBytes;n[c>>>5]|=128<<24-c%32;var e=u.floor(a/
4294967296);n[(c+64>>>9<<4)+15]=(e<<8|e>>>24)&16711935|(e<<24|e>>>8)&4278255360;n[(c+64>>>9<<4)+14]=(a<<8|a>>>24)&16711935|(a<<24|a>>>8)&4278255360;b.sigBytes=4*(n.length+1);this._process();b=this._hash;n=b.words;for(a=0;4>a;a++)c=n[a],n[a]=(c<<8|c>>>24)&16711935|(c<<24|c>>>8)&4278255360;return b},clone:function(){var b=v.clone.call(this);b._hash=this._hash.clone();return b}});t.MD5=v._createHelper(r);t.HmacMD5=v._createHmacHelper(r)})(Math);
(function(){var u=CryptoJS,p=u.lib,d=p.Base,l=p.WordArray,p=u.algo,s=p.EvpKDF=d.extend({cfg:d.extend({keySize:4,hasher:p.MD5,iterations:1}),init:function(d){this.cfg=this.cfg.extend(d)},compute:function(d,r){for(var p=this.cfg,s=p.hasher.create(),b=l.create(),u=b.words,q=p.keySize,p=p.iterations;u.length<q;){n&&s.update(n);var n=s.update(d).finalize(r);s.reset();for(var a=1;a<p;a++)n=s.finalize(n),s.reset();b.concat(n)}b.sigBytes=4*q;return b}});u.EvpKDF=function(d,l,p){return s.create(p).compute(d,
l)}})();
CryptoJS.lib.Cipher||function(u){var p=CryptoJS,d=p.lib,l=d.Base,s=d.WordArray,t=d.BufferedBlockAlgorithm,r=p.enc.Base64,w=p.algo.EvpKDF,v=d.Cipher=t.extend({cfg:l.extend(),createEncryptor:function(e,a){return this.create(this._ENC_XFORM_MODE,e,a)},createDecryptor:function(e,a){return this.create(this._DEC_XFORM_MODE,e,a)},init:function(e,a,b){this.cfg=this.cfg.extend(b);this._xformMode=e;this._key=a;this.reset()},reset:function(){t.reset.call(this);this._doReset()},process:function(e){this._append(e);return this._process()},
finalize:function(e){e&&this._append(e);return this._doFinalize()},keySize:4,ivSize:4,_ENC_XFORM_MODE:1,_DEC_XFORM_MODE:2,_createHelper:function(e){return{encrypt:function(b,k,d){return("string"==typeof k?c:a).encrypt(e,b,k,d)},decrypt:function(b,k,d){return("string"==typeof k?c:a).decrypt(e,b,k,d)}}}});d.StreamCipher=v.extend({_doFinalize:function(){return this._process(!0)},blockSize:1});var b=p.mode={},x=function(e,a,b){var c=this._iv;c?this._iv=u:c=this._prevBlock;for(var d=0;d<b;d++)e[a+d]^=
c[d]},q=(d.BlockCipherMode=l.extend({createEncryptor:function(e,a){return this.Encryptor.create(e,a)},createDecryptor:function(e,a){return this.Decryptor.create(e,a)},init:function(e,a){this._cipher=e;this._iv=a}})).extend();q.Encryptor=q.extend({processBlock:function(e,a){var b=this._cipher,c=b.blockSize;x.call(this,e,a,c);b.encryptBlock(e,a);this._prevBlock=e.slice(a,a+c)}});q.Decryptor=q.extend({processBlock:function(e,a){var b=this._cipher,c=b.blockSize,d=e.slice(a,a+c);b.decryptBlock(e,a);x.call(this,
e,a,c);this._prevBlock=d}});b=b.CBC=q;q=(p.pad={}).Pkcs7={pad:function(a,b){for(var c=4*b,c=c-a.sigBytes%c,d=c<<24|c<<16|c<<8|c,l=[],n=0;n<c;n+=4)l.push(d);c=s.create(l,c);a.concat(c)},unpad:function(a){a.sigBytes-=a.words[a.sigBytes-1>>>2]&255}};d.BlockCipher=v.extend({cfg:v.cfg.extend({mode:b,padding:q}),reset:function(){v.reset.call(this);var a=this.cfg,b=a.iv,a=a.mode;if(this._xformMode==this._ENC_XFORM_MODE)var c=a.createEncryptor;else c=a.createDecryptor,this._minBufferSize=1;this._mode=c.call(a,
this,b&&b.words)},_doProcessBlock:function(a,b){this._mode.processBlock(a,b)},_doFinalize:function(){var a=this.cfg.padding;if(this._xformMode==this._ENC_XFORM_MODE){a.pad(this._data,this.blockSize);var b=this._process(!0)}else b=this._process(!0),a.unpad(b);return b},blockSize:4});var n=d.CipherParams=l.extend({init:function(a){this.mixIn(a)},toString:function(a){return(a||this.formatter).stringify(this)}}),b=(p.format={}).OpenSSL={stringify:function(a){var b=a.ciphertext;a=a.salt;return(a?s.create([1398893684,
1701076831]).concat(a).concat(b):b).toString(r)},parse:function(a){a=r.parse(a);var b=a.words;if(1398893684==b[0]&&1701076831==b[1]){var c=s.create(b.slice(2,4));b.splice(0,4);a.sigBytes-=16}return n.create({ciphertext:a,salt:c})}},a=d.SerializableCipher=l.extend({cfg:l.extend({format:b}),encrypt:function(a,b,c,d){d=this.cfg.extend(d);var l=a.createEncryptor(c,d);b=l.finalize(b);l=l.cfg;return n.create({ciphertext:b,key:c,iv:l.iv,algorithm:a,mode:l.mode,padding:l.padding,blockSize:a.blockSize,formatter:d.format})},
decrypt:function(a,b,c,d){d=this.cfg.extend(d);b=this._parse(b,d.format);return a.createDecryptor(c,d).finalize(b.ciphertext)},_parse:function(a,b){return"string"==typeof a?b.parse(a,this):a}}),p=(p.kdf={}).OpenSSL={execute:function(a,b,c,d){d||(d=s.random(8));a=w.create({keySize:b+c}).compute(a,d);c=s.create(a.words.slice(b),4*c);a.sigBytes=4*b;return n.create({key:a,iv:c,salt:d})}},c=d.PasswordBasedCipher=a.extend({cfg:a.cfg.extend({kdf:p}),encrypt:function(b,c,d,l){l=this.cfg.extend(l);d=l.kdf.execute(d,
b.keySize,b.ivSize);l.iv=d.iv;b=a.encrypt.call(this,b,c,d.key,l);b.mixIn(d);return b},decrypt:function(b,c,d,l){l=this.cfg.extend(l);c=this._parse(c,l.format);d=l.kdf.execute(d,b.keySize,b.ivSize,c.salt);l.iv=d.iv;return a.decrypt.call(this,b,c,d.key,l)}})}();
(function(){for(var u=CryptoJS,p=u.lib.BlockCipher,d=u.algo,l=[],s=[],t=[],r=[],w=[],v=[],b=[],x=[],q=[],n=[],a=[],c=0;256>c;c++)a[c]=128>c?c<<1:c<<1^283;for(var e=0,j=0,c=0;256>c;c++){var k=j^j<<1^j<<2^j<<3^j<<4,k=k>>>8^k&255^99;l[e]=k;s[k]=e;var z=a[e],F=a[z],G=a[F],y=257*a[k]^16843008*k;t[e]=y<<24|y>>>8;r[e]=y<<16|y>>>16;w[e]=y<<8|y>>>24;v[e]=y;y=16843009*G^65537*F^257*z^16843008*e;b[k]=y<<24|y>>>8;x[k]=y<<16|y>>>16;q[k]=y<<8|y>>>24;n[k]=y;e?(e=z^a[a[a[G^z]]],j^=a[a[j]]):e=j=1}var H=[0,1,2,4,8,
16,32,64,128,27,54],d=d.AES=p.extend({_doReset:function(){for(var a=this._key,c=a.words,d=a.sigBytes/4,a=4*((this._nRounds=d+6)+1),e=this._keySchedule=[],j=0;j<a;j++)if(j<d)e[j]=c[j];else{var k=e[j-1];j%d?6<d&&4==j%d&&(k=l[k>>>24]<<24|l[k>>>16&255]<<16|l[k>>>8&255]<<8|l[k&255]):(k=k<<8|k>>>24,k=l[k>>>24]<<24|l[k>>>16&255]<<16|l[k>>>8&255]<<8|l[k&255],k^=H[j/d|0]<<24);e[j]=e[j-d]^k}c=this._invKeySchedule=[];for(d=0;d<a;d++)j=a-d,k=d%4?e[j]:e[j-4],c[d]=4>d||4>=j?k:b[l[k>>>24]]^x[l[k>>>16&255]]^q[l[k>>>
8&255]]^n[l[k&255]]},encryptBlock:function(a,b){this._doCryptBlock(a,b,this._keySchedule,t,r,w,v,l)},decryptBlock:function(a,c){var d=a[c+1];a[c+1]=a[c+3];a[c+3]=d;this._doCryptBlock(a,c,this._invKeySchedule,b,x,q,n,s);d=a[c+1];a[c+1]=a[c+3];a[c+3]=d},_doCryptBlock:function(a,b,c,d,e,j,l,f){for(var m=this._nRounds,g=a[b]^c[0],h=a[b+1]^c[1],k=a[b+2]^c[2],n=a[b+3]^c[3],p=4,r=1;r<m;r++)var q=d[g>>>24]^e[h>>>16&255]^j[k>>>8&255]^l[n&255]^c[p++],s=d[h>>>24]^e[k>>>16&255]^j[n>>>8&255]^l[g&255]^c[p++],t=
d[k>>>24]^e[n>>>16&255]^j[g>>>8&255]^l[h&255]^c[p++],n=d[n>>>24]^e[g>>>16&255]^j[h>>>8&255]^l[k&255]^c[p++],g=q,h=s,k=t;q=(f[g>>>24]<<24|f[h>>>16&255]<<16|f[k>>>8&255]<<8|f[n&255])^c[p++];s=(f[h>>>24]<<24|f[k>>>16&255]<<16|f[n>>>8&255]<<8|f[g&255])^c[p++];t=(f[k>>>24]<<24|f[n>>>16&255]<<16|f[g>>>8&255]<<8|f[h&255])^c[p++];n=(f[n>>>24]<<24|f[g>>>16&255]<<16|f[h>>>8&255]<<8|f[k&255])^c[p++];a[b]=q;a[b+1]=s;a[b+2]=t;a[b+3]=n},keySize:8});u.AES=p._createHelper(d)})();

hljs.initHighlightingOnLoad();
</script></head><body><a href="?delete=1"><button id="del-btn">DEL</button></a><pre id="container"><code id="paste">Decrypting&hellip;</code></pre><script>document.getElementById("paste").innerText=CryptoJS.AES.decrypt('<?php echo $paste ?>', window.location.href.split("#", 2)[1]).toString(CryptoJS.enc.Utf8);</script></body></html>