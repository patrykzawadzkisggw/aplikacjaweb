const Frm = document.querySelector("#login")
const phone = Frm.querySelector("#phone")
const password = Frm.querySelector("#password")


function validate(obj, regex,comment) {
    const nameVal = obj.value
    const nameRegex= regex
    nmaeComment=obj.parentElement.parentElement.querySelector('span')
    if(nameVal===null || nameVal===''|| !nameRegex.test(nameVal)) {
        nmaeComment.textContent=comment
        obj.classList.add('error')
        return false
    } else {
        nmaeComment.textContent=""
        obj.classList.remove('error')
        return true
    }
}
Frm.addEventListener("submit", e =>{
    e.preventDefault()
    phone.value= phone.value.trim()
    const v3 =validate(phone,/^(\+\d{1,4}[- ]?)?\d{3,}([ -]?\d{2,}){1,}$/,"zły numer telefonu")
    const v4 =validate(password,/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/,"Złe hasło")
    if(v3&&v4) {
        Frm.submit()
    }
})
