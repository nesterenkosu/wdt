(function(){
	tinymce.PluginManager.add(
		'demobutton', //id создаваемой кнопки
		function(editor,url){
			editor.addButton(
				'demobutton', //id создаваемой кнопки
				//свойства создаваемой кнопки
				//в виде объекта JavaScript
				{
					text: 'Шорткод', //Текст, выводимый на кнопке
					title: 'Просто демонстрационная кнопка', //Всплывающая подсказка, выводимая при наведении мыши
					//Обработчик нажатия на кнопку
					onclick: function() {
						selectedText=tinyMCE.activeEditor.selection.getContent({format: 'raw'});
						editor.insertContent("[demoshort]"+selectedText+"[/demoshort]");
					}	
					
				}
			);
		}
	);
})();