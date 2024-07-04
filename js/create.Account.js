const Frm = document.querySelector("#createAccount")
const name = Frm.querySelector("#name")
const surrname = Frm.querySelector("#surrname")
const phone = Frm.querySelector("#phone")
const plik = Frm.querySelector("#plik")
const password = Frm.querySelector("#password")
const submit1 = Frm.querySelector("#submit1")
Frm.addEventListener("change", e=> {
    if(this.plik.files.length>=1) Frm.submit()
})
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
    if(this.plik.files.length>=1) Frm.submit()
    console.log('click')
    name.value= name.value.trim()
    const v1 =validate(name,/^[^\d\W]{3,}$/i,"Musisz podać imie")
    surrname.value= surrname.value.trim()
    const v2 =validate(surrname,/^[^\d\W]{3,}$/i,"Musisz podać nazwisko")
    phone.value= phone.value.trim()
    const v3 =validate(phone,/^(\+\d{1,4}[- ]?)?\d{3,}([ -]?\d{2,}){1,}$/,"Musisz podać prawidłowy numer telefonu")
    const v4 =validate(password,/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/,"hasło musi spełniać wymogi co do złożonośći")
    if(v1&&v2&&v3&&v4) {
        Frm.submit()
    }
})
