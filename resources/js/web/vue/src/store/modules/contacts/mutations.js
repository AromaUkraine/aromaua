export default {
    set_central_office : (state, data)  => {
        state.centralOffice = data;
    },
    set_offices: (state, data) =>{
        data.map( item => {
            if(item.map) {
                state.officesWithMap.push(item)
            }else{
                state.officeWithoutMap.push(item)
            }

            // if(item.map) state.officesWithMap.push(item)
            // else state.officesWithMap.push(item)
        })

        // state.offices = data
    }
};
