
import Swal from 'sweetalert2';
import axios from 'axios';

var currentProject = null;

//Success Message
const successMessage = (msg) => {
    Swal.fire({
        position: 'top-end',
        toast: true,
        timer: 2000,
        titleText: msg, 
        icon: 'success',
        showConfirmButton: false,
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
        timer: 2000,
        titleText: msg, 
        icon: 'error',
        showConfirmButton: false,
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









export { successMessage, errorMessage, setCurrentProject };