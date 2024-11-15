import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

document
    .querySelectorAll('.form__add-item-button')
    .forEach((btn: Element) => {
        btn.addEventListener("click", addFormToCollection)
    });
document
    .querySelectorAll('[data-index][data-prototype] > li')
    .forEach((level: Element) => {
        addTagFormDeleteLink(level)
    })

function addFormToCollection({currentTarget}: Event) {
    if (currentTarget instanceof HTMLElement) {
        const collectionHolder = document.querySelector(`[data-form-collection=${currentTarget.dataset.collectionHolderClass}]`) as HTMLElement;

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
    const removeFormButton: HTMLButtonElement = document.createElement('button');
    removeFormButton.innerText = 'Delete';

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e: MouseEvent) => {
        e.preventDefault();
        // remove the li for the level form
        item.remove();
    });
}

document
    .querySelectorAll('button[data-check-value][data-check-route]')
    .forEach(function (el: Element) {
        if (el instanceof HTMLButtonElement) {
            const {dataset} = el;
            const checkRoute: string | undefined = dataset.checkRoute;
            const checkVal: string | undefined = dataset.checkValue;
            if (checkRoute && checkVal) {
                el.addEventListener('click', (el: MouseEvent) => {
                    fetch(checkRoute)
                        .then((resp: Response) => resp.json())
                        .then(val => window.alert(`Roll for '${checkVal}': ${val}`))
                })
            }
        }
    })

console.log('loaded app.ts');
