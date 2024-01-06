import Swal from 'sweetalert2'
import axios from 'axios'
import { trnsl } from '@/Lang/languages';

var currentProject = null;

//Success Message
const successMessage = (msg) => {
    Swal.fire({
        position: 'top-end',
        toast: true,
        titleText: msg, 
        icon: 'success',
        showConfirmButton: false,
        timer: 2000,
        showClass: {
            popup: '',
            icon: '',
        },
    });
}

//Error Message
const errorMessage = (msg) => {
    Swal.fire({
        position: 'top-end',
        toast: true,
        titleText: msg, 
        icon: 'error',
        showConfirmButton: false,
        timer: 2000,
        showClass: {
            popup: '',
            icon: '',
        },
    });
}



const setCurrentProject = (id) => {
    
    axios.get('/api/setCurrentProject/'+id)
        .then(response=>{
            console.log('grabado '+ response.data)
        })
        .catch(error=>{
            console.log(error)
        })
}


const dialogBox = ( title, message ) => {
    return Swal.mixin({
        buttonsStyling:true,
        toast: true,
        titleText: title,
        text: message,
        icon: 'question', 
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-check"></i>' + ' ' + trnsl('content.yes'),
        cancelButtonText: '<i class="fa fa-ban"></i>' + ' ' + trnsl('content.no'),
        showClass: {
            popup: '',
            icon: '',
        },
    }) 
}

const getError = (errors) => {
    var result = ''
    if (typeof errors === 'object') {
        for (var prop in errors) {
            if (errors.hasOwnProperty(prop)) {
                result += errors[prop] + '\n'
            }
        }
        return result
    } else {
        return result
    }
}


export { successMessage, errorMessage, setCurrentProject, dialogBox, getError };