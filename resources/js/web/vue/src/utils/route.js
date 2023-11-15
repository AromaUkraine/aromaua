const routes = require('../../../../routes/api.json');

// route(string name, array params  )
export default function () {
    let args = Array.prototype.slice.call(arguments);
    let name = args.shift();


    if(routes[name] === undefined){
        console.error(`Route by name ${name} undefined`);
    }else{
        let uri = routes[name].split('/').map(str => str[0] === '{' ? args.shift() : str).join('/');
        return `/${uri}`;
    }
}
