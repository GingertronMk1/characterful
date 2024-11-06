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

function addFormToCollection(e) {
    const collectionHolder: HTMLElement = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass) as HTMLElement;

    const item: HTMLLIElement = document.createElement('li');
    const { dataset } = collectionHolder;

    item.innerHTML = dataset
        .prototype
        .replace(
            /__name__/g,
            dataset.index
        );

    addTagFormDeleteLink(item);
    collectionHolder.appendChild(item);

    collectionHolder.dataset.index = (parseInt(dataset.index) + 1).toString();
}
function addTagFormDeleteLink(item) {
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
