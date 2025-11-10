let template = document.getElementsByTagName('template')[0];
let clone = template.content.cloneNode(true);
document.getElementById('resalat_container').appendChild(clone);