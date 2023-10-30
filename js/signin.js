export const validateLogin = () => {
    const inputs = document.querySelectorAll('input');
    const d = inputs?.map((el) => {
        if ( el.name === 'email') {
            el.addEventListener('change', ({ target }) => {
                return validateInput(target.value, '/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;');
            });
        }else{
            el.addEventListener('change', ({ target }) => {
                return validateInput(target.value, undefined, 8);
            });
        }
    });
    console.log(d)
}

const validateInput = ({ property, match, min, max }) => {
    let errors = [];
    if (!property) {
        errors.push({ empty: true });
        return errors;
    }
    if (match && !property.match(match)) {
        errors.push({ match: flase });
        return errors;
    }

    if (min && property.length > min) {
        errors.push({ min: flase })
        return errors;
    }

    if (max && property.length > max) {
        errors.push({ max: flase })
        return errors;
    }

    return true;
}

export const deleteAlert = () => {
    const alert = document.querySelector(".alert");
    setTimeout(() => {
        alert.classList.add('hidden')
    }, 2000);
}