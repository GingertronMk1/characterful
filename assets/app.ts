import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document
    .querySelectorAll('.add_item_link')
    .forEach((btn: Element) => {
        btn.addEventListener("click", addFormToCollection)
    });
document
    .querySelectorAll('ul.levels > li')
    .forEach((level: Element) => {
        addTagFormDeleteLink(level)
    })

function addFormToCollection({currentTarget}: Event) {
    if (currentTarget instanceof HTMLElement) {
        const collectionHolder = document.querySelector(`.${currentTarget.dataset.collectionHolderClass}`) as HTMLElement;

        const item: HTMLLIElement = document.createElement('li');
        const {dataset} = collectionHolder;
        if (!(dataset.index === undefined || dataset.prototype === undefined)) {
            const {index, prototype} = dataset;

            item.innerHTML = prototype
                .replace(
                    /__name__/g,
                    index
                );

            addTagFormDeleteLink(item);
            collectionHolder.appendChild(item);

            collectionHolder.dataset.index = (parseInt(index) + 1).toString();
        }
    }
}

function addTagFormDeleteLink(item: Element) {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerText = 'Delete this level';

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the level form
        item.remove();
    });
}

console.log('loaded app.js');
