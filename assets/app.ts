import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import 'bootstrap';

document
    .querySelectorAll('[data-collection-holder-class]')
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

        const item: HTMLDivElement = document.createElement('div');
        const {dataset} = collectionHolder;
        if (dataset.index !== undefined && dataset.prototype !== undefined) {
            const {index, prototype} = dataset;

            item.innerHTML = prototype
                .replace(
                    /__name__/g,
                    index
                );

            addTagFormDeleteLink(item);
            item.classList.add('form-control');
            collectionHolder.appendChild(item);

            collectionHolder.dataset.index = (parseInt(index) + 1).toString();
        }
    }
}

function addTagFormDeleteLink(item: Element) {
    const removeFormButton: HTMLButtonElement = document.createElement('button');
    removeFormButton.innerText = 'Delete';
    removeFormButton.classList.add('btn');
    removeFormButton.classList.add('btn-danger');

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
            if (checkRoute !== undefined && checkVal !== undefined) {
                el.addEventListener('click', () => {
                    fetch(checkRoute)
                        .then((resp: Response) => resp.json())
                        .then(function ({ base, mod, total }) {
                            window.alert([
                                `Base roll: ${base}\n`,
                                `Modifier: ${mod}\n`,
                                `Total: ${total}`,
                            ].join('\n'));
                        })
                })
            }
        }
    })

console.log('loaded app.ts');
