import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Highlight from '@tiptap/extension-highlight';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';
import Image from '@tiptap/extension-image';
import YouTube from '@tiptap/extension-youtube';
import TextStyle from '@tiptap/extension-text-style';
import FontFamily from '@tiptap/extension-font-family';
import { Color } from '@tiptap/extension-color';
import Bold from '@tiptap/extension-bold';

document.addEventListener('livewire:init', function() {
    console.log('Livewire inicializado');
    
    Livewire.on('initializeEditor', function(data) {
        console.log('initializeEditor recibido:', data);

        if (document.getElementById("posts-editor")) {
            console.log('Elemento posts-editor encontrado, inicializando TipTap...');

            const FontSizeTextStyle = TextStyle.extend({
                addAttributes() {
                    return {
                        fontSize: {
                            default: null,
                            parseHTML: element => element.style.fontSize,
                            renderHTML: attributes => {
                                if (!attributes.fontSize) {
                                    return {};
                                }
                                return { style: 'font-size: ' + attributes.fontSize };
                            },
                        },
                    };
                },
            });

            const CustomBold = Bold.extend({
                // Override the renderHTML method
                renderHTML({ mark, HTMLAttributes }) {
                    const { style, ...rest } = HTMLAttributes;

                    // Merge existing styles with font-weight
                    const newStyle = 'font-weight: bold;' + (style ? ' ' + style : '');

                    return ['span', { ...rest, style: newStyle.trim() }, 0];
                },
                // Ensure it doesn't exclude other marks
                addOptions() {
                    return {
                        ...this.parent?.(),
                        HTMLAttributes: {},
                    };
                },
            });

            // tip tap editor setup
            const editor = new Editor({
                element: document.querySelector('#posts-editor'),
                extensions: [
                    StarterKit.configure({
                        textStyle: false,
                        bold: false,
                        marks: {
                            bold: false,
                        },
                    }),
                    // Include the custom Bold extension
                    CustomBold,
                    Color,
                    FontSizeTextStyle,
                    FontFamily,
                    Highlight,
                    Underline,
                    Link.configure({
                        openOnClick: false,
                        autolink: true,
                        defaultProtocol: 'https',
                    }),
                    TextAlign.configure({
                        types: ['heading', 'paragraph'],
                    }),
                    Image,
                    YouTube,
                ],
                content: data.content || '',
                editorProps: {
                    attributes: {
                        class: 'format lg:format-lg dark:format-invert focus:outline-none format-blue max-w-none',
                    },
                },
                onUpdate({ editor }){
                    Livewire.dispatch('updateContent', { content: editor.getHTML() });
                }
            });

            // Basic button event listeners with null checks
            const addButtonListener = (buttonId, callback) => {
                const button = document.getElementById(buttonId);
                if (button) {
                    button.addEventListener('click', callback);
                } else {
                    console.warn(`Button with ID '${buttonId}' not found`);
                }
            };

            // Set up custom event listeners for the buttons
            addButtonListener('toggleBoldButton', () => editor.chain().focus().toggleBold().run());
            addButtonListener('toggleItalicButton', () => editor.chain().focus().toggleItalic().run());
            addButtonListener('toggleUnderlineButton', () => editor.chain().focus().toggleUnderline().run());
            addButtonListener('toggleStrikeButton', () => editor.chain().focus().toggleStrike().run());
            
            addButtonListener('toggleHighlightButton', () => {
                const isHighlighted = editor.isActive('highlight');
                editor.chain().focus().toggleHighlight({
                    color: isHighlighted ? undefined : '#ffc078'
                }).run();
            });

            addButtonListener('toggleLinkButton', () => {
                const url = window.prompt('Enter URL:', 'https://flowbite.com');
                if (url) {
                    editor.chain().focus().toggleLink({ href: url }).run();
                }
            });

            addButtonListener('removeLinkButton', () => editor.chain().focus().unsetLink().run());
            addButtonListener('toggleCodeButton', () => editor.chain().focus().toggleCode().run());

            // Text alignment buttons
            addButtonListener('toggleLeftAlignButton', () => editor.chain().focus().setTextAlign('left').run());
            addButtonListener('toggleCenterAlignButton', () => editor.chain().focus().setTextAlign('center').run());
            addButtonListener('toggleRightAlignButton', () => editor.chain().focus().setTextAlign('right').run());

            // List buttons
            addButtonListener('toggleListButton', () => editor.chain().focus().toggleBulletList().run());
            addButtonListener('toggleOrderedListButton', () => editor.chain().focus().toggleOrderedList().run());

            // Other formatting buttons
            addButtonListener('toggleBlockquoteButton', () => editor.chain().focus().toggleBlockquote().run());
            addButtonListener('toggleHRButton', () => editor.chain().focus().setHorizontalRule().run());

            addButtonListener('addImageButton', () => {
                const url = window.prompt('Enter image URL:', 'https://placehold.co/600x400');
                if (url) {
                    editor.chain().focus().setImage({ src: url }).run();
                }
            });

            addButtonListener('addVideoButton', () => {
                const url = window.prompt('Enter YouTube URL:', 'https://www.youtube.com/watch?v=KaLxCiilHns');
                if (url) {
                    editor.commands.setYoutubeVideo({
                        src: url,
                        width: 640,
                        height: 480,
                    });
                }
            });

            // Safely get dropdown instances
            const getDropdownInstance = (dropdownId) => {
                try {
                    if (typeof FlowbiteInstances !== 'undefined' && document.getElementById(dropdownId)) {
                        return FlowbiteInstances.getInstance('Dropdown', dropdownId);
                    }
                } catch (error) {
                    console.warn(`Could not get dropdown instance for '${dropdownId}':`, error);
                }
                return null;
            };

            const typographyDropdown = getDropdownInstance('typographyDropdown');
            const textSizeDropdown = getDropdownInstance('textSizeDropdown');
            const fontFamilyDropdown = getDropdownInstance('fontFamilyDropdown');

            // Typography dropdown
            addButtonListener('toggleParagraphButton', () => {
                editor.chain().focus().setParagraph().run();
                if (typographyDropdown && typeof typographyDropdown.hide === 'function') {
                    typographyDropdown.hide();
                }
            });

            // Heading level buttons
            document.querySelectorAll('[data-heading-level]').forEach((button) => {
                button.addEventListener('click', () => {
                    const level = button.getAttribute('data-heading-level');
                    editor.chain().focus().toggleHeading({ level: parseInt(level) }).run();
                    if (typographyDropdown && typeof typographyDropdown.hide === 'function') {
                        typographyDropdown.hide();
                    }
                });
            });

            // Text size buttons
            document.querySelectorAll('[data-text-size]').forEach((button) => {
                button.addEventListener('click', () => {
                    const fontSize = button.getAttribute('data-text-size');
                    editor.chain().focus().setMark('textStyle', { fontSize }).run();
                    if (textSizeDropdown && typeof textSizeDropdown.hide === 'function') {
                        textSizeDropdown.hide();
                    }
                });
            });

            // Color picker
            const colorPicker = document.getElementById('color');
            if (colorPicker) {
                colorPicker.addEventListener('input', (event) => {
                    const selectedColor = event.target.value;
                    editor.chain().focus().setColor(selectedColor).run();
                });
            }

            // Color buttons
            document.querySelectorAll('[data-hex-color]').forEach((button) => {
                button.addEventListener('click', () => {
                    const selectedColor = button.getAttribute('data-hex-color');
                    editor.chain().focus().setColor(selectedColor).run();
                });
            });

            addButtonListener('reset-color', () => editor.commands.unsetColor());

            // Font family buttons
            document.querySelectorAll('[data-font-family]').forEach((button) => {
                button.addEventListener('click', () => {
                    const fontFamily = button.getAttribute('data-font-family');
                    editor.chain().focus().setFontFamily(fontFamily).run();
                    if (fontFamilyDropdown && typeof fontFamilyDropdown.hide === 'function') {
                        fontFamilyDropdown.hide();
                    }
                });
            });

        } else {
            alert('Error: Elemento posts-editor NO encontrado');
        }
    });
});