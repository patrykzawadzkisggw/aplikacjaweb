const url = new URL(window.location.href);
const product = url.searchParams.get("product");

class Description {
    constructor(id) {
        this.id=id
    }
    async init() {
        this.title = document.querySelector("h2")
        this.close = document.querySelector(".close img")
        this.price = document.querySelector(".price")
        this.desc = document.querySelector(".opis")
        this.titleimg = document.querySelector(".titleimg")
        this.image = document.querySelector("img")
        this.prodid = document.querySelector(".prodid")
        this.close.addEventListener("click", _=> {
            window.history.back()
        })
        await this.loadData()
        this.render()
    }

    async loadData() {
        const serverData = await fetch(`http://localhost/witryna/api.php/pudelko/${this.id}`)
        const jsonData = await serverData.json()

        if(jsonData.length==0) {
            console.log("brak danych")
            return;
        }
        this.box = jsonData[0]
    }

    render() {
        this.title.textContent=this.box.NazwaPudelka
        this.price.textContent=this.box.Cena+" zł"
        this.desc.textContent=this.box.Opis
        this.titleimg.src=this.box.url
        this.prodid.value=this.id
    }
}

const opis = new Description(product)
opis.init()