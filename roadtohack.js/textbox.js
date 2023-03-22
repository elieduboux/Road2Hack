/**
 * Class represeting the box to display text from all game elements.
 * @extends HTMLElement
 */
class TextDisplay extends HTMLElement {

    /**
     * Create the text display.
     */
    constructor() {
        super();

        const shadow = this.attachShadow({ mode: 'open' });

        shadow.innerHTML = `
      <style>
        :host {
          --primary-color: #000;
          --secondary-color: #fff;
          contain: strict;
        }
  
        @media (prefers-color-scheme: dark) {
          :host {
            --primary-color: #fff;
            --secondary-color: #000;
          }
        }  
        .text-box,
        .continue {
          position: fixed;
          bottom: 10px;
          left: 56%;
          transform: translateX(-50%);
          font-family: monospace;
          border: 2px solid var(--primary-color);
          box-shadow: 1px 1px 0px var(--secondary-color), -1px -1px 0px var(--secondary-color);
        }
  
        .text-box {
          padding: 1em;
          background-color: var(--secondary-color);
          color: var(--primary-color);
          line-height: 1.2;
          width: 40ch;
          height: 4em;
          box-sizing: border-box;
          hyphens: auto;
        }
  
        @media screen and (orientation: portrait) {
          .text-box {
            bottom: var(--utility-bar-size);
          }
        }
  
        .char {
          opacity: 0;
          visibility: hidden;
          font-size: 0.4em;

        }
  
        .char.visible {
          opacity: 1;
          visibility: visible;
        }
  
        .ellipsis-before::before {
          content: '…';
        }
  
        .ellipsis-after::after {
          content: '…';
        }
  
        .continue {
          cursor: pointer;
          border: 2px solid var(--primary-color);
          font-family: monospace;
          font-size: 0.5em;
          color: var(--primary-color);
          background-color: var(--secondary-color);
          bottom: 1em;
          left: 85%
        }
  
        .continue:hover {
          background-color: var(--primary-color);
          color: var(--secondary-color);
        }
  
        .accessible-text-box {
          clip: rect(1px, 1px, 1px, 1px);
          clip-path: inset(50%);
          height: 1px;
          width: 1px;
          margin: -1px;
          overflow: hidden;
          padding: 0;
          position: absolute;
        }
      </style>
      <p id="text-box" class="text-box" hidden></p>
      <div id="accessible-text-box" class="accessible-text-box" role="region" aria-live="assertive" aria-atomic="true" aria-relevant="additions"></div>
      <button id="continue" class="continue" hidden>Continue…</button>`;

        this.continueButton = shadow.getElementById('continue');
        this.textBox = shadow.getElementById('text-box');
        this.accessibleTextBox = shadow.getElementById('accessible-text-box');

        const self = this;
        this.continueButton.addEventListener('pointerup', event => {
            if (this.textBox.hasAttribute('data-complete')) {
                this.continueButton.hidden = true;
                this.textBox.hidden = true;
                this.textBox.removeAttribute('data-complete');
                return;
            }
            Array.from(self.shadowRoot.querySelectorAll('.visible'))
                .map(item => item.hidden = true);
            event.target.hidden = true;
            self.showLetters();
        }, { passive: true });
    }

    /**
     * Set the attributes to watch for changes.
     * @return {Array} An array of attributes.
     */
    static get observedAttributes() { return ['text']; }

    /**
     * Generator to retrieve the next letter in the sequence.
     * @param {Array} letters - An array of characters.
     * @yields {string} The next letter in sequence.
     */
    *
    letterGenerator(letters) {
        let index = 0;
        while (index < letters.length) {
            yield letters[index];
            index++;
        }
    }

    /**
     * Print letters in typewriter effect. Automatically page content to fit
     * the dimesions of the box.
     * @return {number} either the current index if we haven't reached the end
     * of the page, or the intervalID if we have.
     */
    showLetters() {
        let index = 1;
        // Try to break pages on a whitespace character.
        let lookForWhitespaceChar = false;
        const intervalID = window.setInterval(() => {
            let letter = this.letters.next();
            if (letter.done) {
                this.continueButton.textContent = 'Done';
                this.continueButton.hidden = false;
                this.textBox.setAttribute('data-complete', '');
                return window.clearInterval(intervalID);
            }
            lookForWhitespaceChar = lookForWhitespaceChar ? lookForWhitespaceChar : false;
            if (index % 100 === 0) lookForWhitespaceChar = true;
            letter.value.classList.add('visible');
            if (lookForWhitespaceChar && !letter.value.textContent.trim()) {
                window.clearInterval(intervalID);
                letter.value.previousElementSibling.classList.add('ellipsis-after');
                letter.value.nextElementSibling.classList.add('ellipsis-before');
                this.continueButton.hidden = false;
                return index;
            }
            index++;
        }, 25);
    }

    /**
     * Respond to attribute changes.
     * @param {string} name - The name of the attribute changed.
     * @param {string} oldValue - The previous value of the attrbute.
     * @param {string} newValue - The just-changed value of the attribute.
     * @see {@linkcode TextDisplay#observedAttributes}
     * @return {void}
     */
    attributeChangedCallback(name, oldValue, newValue) {
        if (!newValue) return;
        this.accessibleTextBox.textContent = newValue;
        this.continueButton.textContent = 'Continue…';
        this.textBox.hidden = false;
        this.textBox.innerHTML = newValue
            .trim()
            .split('')
            .map(char => `<span class="char">${char}</span>`)
            .join('');
        this.letters = this.letterGenerator(Array.from(this.textBox.children));
        this.showLetters();
    }
}
customElements.define('text-display', TextDisplay);

/* Demo enabling code */

const textBox = document.getElementById('text-box');

const demoText = {
    history: "not available",
    help: "Tu es une personne incroyable Tu es une personne incroyable Tu es une personne incroyable Tu es une personne incroyable Tu es une personne incroyable Tu es une personne incroyable Tu es une personne incroyable "
};

document.documentElement.addEventListener('pointerup', event => {
    const button = event.target.closest('button');
    if (!button) return;
    if (button.id === 'submit') {
        textBox.setAttribute('text', document.getElementById('custom').value);
        return;
    }
    textBox.setAttribute('text', demoText[button.id]);
});