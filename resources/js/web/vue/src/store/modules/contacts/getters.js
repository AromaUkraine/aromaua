export default {
    centralOffice: state => state.centralOffice,
    officeWithMapByCountry : state => (id) => {
        return state.officesWithMap.filter( (office) => office.country_id === id)
    },
    officeWithoutMapByCountry : state => (id) => {
        return state.officeWithoutMap.filter( (office) => office.country_id === id)
    }

};
