let entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};
function escapeHtml(string) {
    return String(string).replace(/[&<>"'/]/g, function (s) {
        return entityMap[s];
    });
}

function remove_spaces(string) {
    return String(string).replace(/[\s]/g, function (s) {
        return '';
    });
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function format_time(s) {
    return new Date(s * 1e3).toISOString().slice(0,-5).replace('T',' ');
}

function create_element(h_tag,h_id,h_class,h_value,h_innerHtml){
    let doc = document.createElement(h_tag);
    if(h_id != null)
        doc.id = h_id;
    if(h_class != null)
        doc.className = h_class;
    if(h_value != null)
        doc.value = h_value;
    if(h_innerHtml != null)
        doc.innerHTML = h_innerHtml;
    return doc;
}

function on_error_animate(node){
    node.animate([
        // keyframes
        { transform: 'translateX(-10px)' },
        { transform: 'translateX(+10px)' },
        { transform: 'translateX(-10px)' },
        { transform: 'translateX(+10px)' }
    ], {
        // timing options
        duration: 200,
        iterations: 1
    });
}

function dropdown(ID) {
    document.getElementById(ID).classList.toggle("show_dropdown");
  }
  