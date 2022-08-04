// only for animation
const circleDiagrams = document.querySelectorAll('.circle-diagram')
circleDiagrams.forEach(circleDiagram => {
  circleDiagram.addEventListener("click", (e)=> animProp(e.target))
  animProp(circleDiagram)
})

function animProp(el){
  gsap.from(el, {"--percent": 0, duration: 3});
}