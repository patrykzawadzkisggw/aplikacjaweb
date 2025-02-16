
class Pudelka {
    constructor(board) {
        this.boar=board
    }
    async init() {
        this.board= document.querySelector(this.boar)
        this.tp1= document.querySelector("#tp1")
        this.filterInput=this.board.parentNode.querySelector('.input.search input')
        this.FilterBtn=this.board.parentNode.querySelector('.filter')
        this.FilterBox=document.querySelector('#filtr')
        this.FilterBoxCloseBtn=document.querySelector('#filtr .close img')
        this.filterInput.addEventListener('change', ()=> this.filter())
        this.startingPrice= document.querySelector('#startingPrice')
        this.startingPrice.addEventListener('change', ()=> this.filter())
        this.endPrice= document.querySelector('#endPrice')
        this.sortOption= document.querySelector('#order')
        this.endPrice.addEventListener('change', ()=> this.filter())
        this.sortOption.addEventListener('change', ()=> this.filter())
        this.FilterBtn.addEventListener('click', ()=> {
            this.FilterBox.classList.remove("hidden")
        })
        this.FilterBoxCloseBtn.addEventListener('click', ()=> this.FilterBox.classList.add("hidden"))
        await this.loadData()
        this.cleanBoard()
        await this.fillBoard()
    }

    async loadData() {
        const serverData = await fetch('api.php/pudelka')
        const jsonData = await serverData.json()

        if(jsonData.length==0) {
            console.log("brak danych")
            return;
        }
        this.boxes = jsonData
    }
    cleanBoard() {
        while(this.board.lastChild) {
            this.board.removeChild(this.board.lastChild)
        }
    }

    createNode(el) {
        const card = this.tp1.cloneNode(true)
        
        card.content.querySelector(".title").textContent=el.NazwaPudelka
        card.content.querySelector(".card").addEventListener('click', _ => {
            window.location.href="description.php?product="+el.idPudelka
        })
        card.content.querySelector(".price").textContent=el.Cena+" zł"
        card.content.querySelector("img").src=el.url
        card.content.querySelector("a").href="description.php?product="+el.idPudelka
        return card.content
    }

    fillBoard() {
        this.boxes.forEach(element => {
            const el = this.createNode(element)
            this.board.appendChild(el)
        });
    }
    filter() {
        
       const pat =new RegExp(this.filterInput.value,"i")
       const elements= this.board.querySelectorAll(".card")
       const startp=parseFloat(startingPrice.value)
       const endp=parseFloat(endPrice.value)
       let elem = []
       elements.forEach(el => {
        elem.push({
            
            element:el,
            title:el.querySelector(".title").textContent,
            price:parseFloat(el.querySelector(".price").textContent.replace(",","."))
        })
        const valEl= el.querySelector(".title").textContent
        console.log(valEl)
        if(pat.test(valEl)) {
            el.classList.remove("hidden")
            
        } else {
            el.classList.add("hidden")
            
        }

       })
       if(this.sortOption.value=="PriceAsc")
       elem= elem.sort((a,b) => a.price-b.price)
       if(this.sortOption.value=="PriceDesc")
       elem= elem.sort((a,b) => b.price-a.price)
       if(this.sortOption.value=="NameAsc")
       elem= elem.sort((a,b) => a.title.localeCompare(b.title))
       if(this.sortOption.value=="NameDesc")
       elem= elem.sort((b,a) => a.title.localeCompare(b.title))
    console.log(elem)
    console.log(this.sortOption.value)
       for(let i=0;i<elem.length;i++) {
        elem[i].element.style.order=i
        if(endp!==null && endp!=='' && endp!==" " && endp <elem[i].price) elem[i].element.classList.add("hidden")
        if(startp!==null && startp!=='' && startp!==" " && startp >elem[i].price) elem[i].element.classList.add("hidden")
       }
    }
}

const pudelka = new Pudelka("#board1")
pudelka.init()


const nav = document.querySelector("nav")
const banner = document.querySelector(".welcome")

const Bammeroptions = {
    rootMargin: "-50px 0px 0px 0px"
}

const sectionObserer = new IntersectionObserver((entries,sectionObserver) => {
    entries.forEach(entry => {
        if(!entry.isIntersecting) {
            nav.classList.add("nav-scroled")
        } else {
            nav.classList.remove("nav-scroled")
        }
    })
},Bammeroptions)

sectionObserer.observe(banner)
