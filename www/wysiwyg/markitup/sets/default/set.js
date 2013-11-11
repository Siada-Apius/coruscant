var mySettings={onShiftEnter:{keepDefault:false,replaceWith:'<br />\n'},onCtrlEnter:{keepDefault:false,openWith:'\n<p>',closeWith:'</p>'},onTab:{keepDefault:false,replaceWith:'    '},
	markupSet:  [
		{name:'Article', openWith:'<article itemprop="articleBody">', closeWith:'</article>' },
		{name:'Paragraph', key:'R', openWith:'<p>', closeWith:'</p>' },
		{name:'Strong', key:'T', openWith:'<strong>', closeWith:'</strong>' },
		{name:'Em', key:'E', openWith:'<em>', closeWith:'</em>' },
		{name:'Bold', key:'B', openWith:'<b>', closeWith:'</b>' },
		{name:'Italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },
		{name:'Citation', key:'4', openWith:'<q>', closeWith:'</q>' },
		{separator:'---------------' },
		{name:'Bulleted List', openWith:'    <li>', closeWith:'</li>', multiline:true, openBlockWith:'<ul>\n', closeBlockWith:'\n</ul>'},
		{name:'Numeric List', openWith:'    <li>', closeWith:'</li>', multiline:true, openBlockWith:'<ol>\n', closeBlockWith:'\n</ol>'},
		{separator:'---------------' },
		{name:'Picture', key:'P', replaceWith:'<div class="cor_text"><img itemprop="image" src="[![Source:!:http://]!]" alt="[![Alternative text]!]" /></div>' },
		{name:'Link', key:'L', openWith:'<a itemprop="url" href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
		{separator:'---------------' },
		{name:'Clean', className:'clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },		
		{name:'Preview', className:'preview',  call:'preview'}
	]
}
