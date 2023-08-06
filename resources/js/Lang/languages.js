import { messagesES } from './es/messages'
import { contentES } from './es/content'

const language = 'es'

function trnsl(expression = ''){
    switch(language){
        case 'es':
            var messages=messagesES
            var content=contentES
    } 
    var exp = expression.toString()
    var attribs = exp.split('.')
    var type = attribs[0]
    var key = attribs[1]
    
    switch (type) {
        case 'content':
            return content[key]
        case 'messages':
            return messages[key]
        default:
            return expression
    }
}

export {trnsl};

