<template>

    <div class="w-full overflow-hidden rounded-lg shadow ">

        <!-- HEADER -->

        <div class="flex bg-neutral-800 border-b p-1 justify-between">
            
            <span class="px-2 py-1 m-1  text-white">
                <p class="text-sm uppercase">{{ table }}</p>
            </span>
            
            <span class="flex bg-white m-1 rounded-lg overflow-hidden">
                <span class="text-sm ml-2 mt-1">
                    <i class="fa fa-search"></i>
                </span>
                <input v-model="textSearch" class="appareance-none focus:outline-none px-2 text-xs" @keyup="search"/>
            </span>
        </div>

        <!-- TABLE -->

        <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-auto" id="dataTable">
            <thead class="bg-neutral-700">
                <tr class="tracking-wide">
                    <template
                        v-for="(header, x) in headers"
                        :key="x"
                    >
                        <th class="px-6 py-2 text-xs text-white tracking-wider">
                            {{ header.text }}
                        </th>
                    </template>
                    <th class="px-6 py-2 text-xs text-white tracking-wider">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(row, y) in page" :key="y">
                    
                    <template
                        v-for="(header, x) in headers"
                        :key="x"
                    >
                        <td v-if="header.align==='right'" class="whitespace-wrap px-6 py-1 text-xs text-gray-500 text-end ">
                            <span v-if="header.type==='text'">
                                {{ showValue(row, header.name) }}
                            </span>
                            <span v-if="header.type==='date'">
                                {{ formatDate(showValue(row, header.name),'dddd MMMM D, YYYY') }}
                            </span>
                            <span v-if="header.type==='image'" class="margin-auto">
                                <img class="object-contain h-10 w-20" :src=" header.path + row[header.name]" alt="">
                            </span>
                        </td>
                        <td v-else-if="header.align==='center'" class="whitespace-wrap px-6 py-1 text-xs text-gray-500 text-center" >
                            <span v-if="header.type==='text'">
                                {{ showValue(row, header.name) }}
                            </span>
                            <span v-if="header.type==='date'">
                                {{ formatDate(showValue(row, header.name),'dddd MMMM D, YYYY') }}
                            </span>
                            <span v-if="header.type==='image'">
                                <img class="m-auto object-contain h-10 w-20" :src=" header.path + row[header.name]" alt="">
                            </span>
                        </td>
                        <td v-else-if="header.align==='left'" class="whitespace-wrap px-6 py-1 text-xs text-gray-500 text-start ">
                            <span v-if="header.type==='text'">
                                {{ showValue(row, header.name) }}
                            </span>
                            <span v-if="header.type==='date'">
                                {{ formatDate(showValue(row, header.name),'dddd MMMM D, YYYY') }}
                            </span>
                            <span v-if="header.type==='image'" class="margin-auto">
                                <img class="object-contain h-10 w-20" :src=" header.path + row[header.name]" alt="">
                            </span>
                        </td>
                    </template>

                    <td class="px-6 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <template 
                                v-for="(action, k) in actions" 
                                :key="k"
                            >
                                <button
                                    v-if="action.color==='primary'"
                                    class="inline-block border-e px-2 py-1 text-green-600 hover:bg-gray-50 focus:relative"
                                    :title="action.text"
                                    @click="selectRow(row, action.name)"
                                >
                                    <i v-if="action.type==='icon'" :class="action.icon"></i>
                                    <p v-if="action.type==='badge'" class="bg-green-600 text-white px-2 py-1 rounded-md">{{ action.text }}</p>
                                </button>
                                <button
                                    v-if="action.color==='secondary'"
                                    class="inline-block border-e px-2 py-1 text-gray-600 hover:bg-gray-50 focus:relative"
                                    :title="action.text"
                                    @click="selectRow(row, action.name)"
                                >
                                    <i v-if="action.type==='icon'" :class="action.icon"></i>
                                    <p v-if="action.type==='badge'" class="bg-gray-600 text-white px-2 py-1 rounded-md">{{ action.text }}</p>
                                </button>
                                <button
                                    v-if="action.color==='danger'"
                                    class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                    :title="action.text"
                                    @click="selectRow(row, action.name)"
                                >
                                    <i v-if="action.type==='icon'" :class="action.icon"></i>
                                    <p v-if="action.type==='badge'" class="bg-red-600 text-white px-2 py-1 rounded-md">{{ action.text }}</p>
                                </button>
                            </template>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- FOOTER -->

        <div class="w-full flex border-t flex-wrap justify-between bg-neutral-700">
            
            <span class="flex p-2 w-full md:w-1/2">
                <span v-if="((dataset.length > rowsPerPage) && !onSearch)" class="flex flex-wrap">
                    <template v-for="(link,i) in links" :key="i">
                        <button v-if="link === currentPage" class="text-xs text-black bg-white rounded border px-1 border-white mx-1 w-10"  @click="selectPage(link)">{{ link }}</button>
                        <button v-else class="text-xs text-white rounded border px-1 border-white mx-1 w-10" @click="selectPage(link)">{{ link }}</button>
                    </template>
                </span>
            </span>
            
            <span v-if="!onSearch" class="flex p-2" >
                <h3 class="text-xs text-white px-2 py-1">
                    {{ trnsl('messages.recordsPerPage') }}
                </h3>
                <select class="text-xs py-0 pr-7 rounded-lg" v-model="rowsPerPage" @change="changeSizePage">
                    <option class="text-xs p-0" value="10">10</option>
                    <option class="text-xs p-0" value="20">20</option>
                    <option class="text-xs p-0" value="30">30</option>
                </select>
            </span>
        </div>

    </div>

</template>

<script setup>
    
    import { ref, reactive, onMounted } from 'vue';
    import { trnsl } from '@/Lang/languages'
    import dayjs from 'dayjs';

    const props = defineProps({
        headers: Array,
        actions: Array,
        dataset: Object,
        table: String,
        fieldSearch: String,
    })

    const emit = defineEmits([
        'select'
    ])
  
    const page = reactive([]);
    const links = reactive([]);
    const rowsPerPage = ref(10);
    const currentPage = ref(1);
    const nPages = ref(1);
    const onSearch = ref(false);
    const textSearch = ref('');

    //Calculate Pages
    const calcPages = () => {
        let np = 0;
        if(props.dataset.length > rowsPerPage.value)  {
            let res = 0;
            res = props.dataset.length % rowsPerPage.value;
            if (res == 0) {
                nPages.value = props.dataset.length / rowsPerPage.value;
            }else{
                nPages.value = ((props.dataset.length - res) / rowsPerPage.value) + 1;
            }
        }
    }

    //Create Links Pagination
    const makeLinks = (pageSelected) => {
        links.lenght = 0;
        if (nPages.value > 9) {
            if ((pageSelected >= 1) && (pageSelected <= 4)) {
                links[0] = '<<'
                for (let i = 1;i <= 5;i++) {
                    links[i] = i 
                }
                links[6] = '...';
                links[7] = nPages.value;
                links[8] = '>>'
            } else if ((pageSelected >= (nPages.value - 3)) && (pageSelected <= nPages.value)) {
                        links[0] = '<<';
                        links[1] = 1;
                        links[2] = '...';
                        let x = nPages.value - 4;
                        for (let i = 3;i <= 7;i++) {
                            links[i] = x;
                            x++
                        }
                        links[8] = '>>';
                    } else {
                                links[0] = '<<';
                                links[1] = 1;
                                links[2] = '...';
                                links[3] = pageSelected - 1;
                                links[4] = pageSelected;
                                links[5] = pageSelected + 1;
                                links[6] = '...';
                                links[7] = nPages.value;
                                links[8] = '>>';
                            }  
        } else {
            for (let i = 0;i <= nPages.value -1;i++) {
                links[i] = i + 1;
            }
        }
    }

    //Change Page Size
    function changeSizePage() {
        calcPages();
        fillPage(1);
        makeLinks(1);
    }

    //Select Page
    function selectPage(pageSelected) {
        if (pageSelected !== '...') {
            if (pageSelected === '<<'){
                if (currentPage.value > 1) {
                    currentPage.value = currentPage.value - 1
                } else {
                    currentPage.value = 1
                }
            } else if (pageSelected === '>>'){
                        if (currentPage.value < nPages.value) {
                            currentPage.value = currentPage.value + 1
                        } else {
                            currentPage.value = nPages.value
                        }
                    } else  {
                        currentPage.value = pageSelected
                    }
                    fillPage(currentPage.value)
                    makeLinks(currentPage.value);
        }
    }

    function formatDate(dateString, format) {
        const date = dayjs(dateString);
        return date.format(format);
    }

    //Show Field
    function showValue (row, name) {
        let value = '';
        var str = name.toString()
        if(str.includes('.')){
            let names = str.split('.');
            if (names.length==2) {
                value = row[names[0]][names[1]];
            } else if (names.length==3) {
                        value = row[names[0]][names[1]][names[2]];
                    }
        } else {
            value = row[str];
        }
        return value
    }

    //Fill Page with Rows
    function fillPage(pageSelected) {
        let rpp = rowsPerPage.value * 1;
        let cp = pageSelected * 1;
        let rowStart = (cp - 1) * rpp;
        let rowEnd = 0;
        if (cp == nPages.value){
            rowEnd = props.dataset.length;
        }else{
            rowEnd = rowStart + rpp - 1;
        }
        page.length = 0;
        let count = 0;
        props.dataset.forEach( (row, i) => {
            if((i>=rowStart)&&(i<=rowEnd)) {
                page[count] = row;
                count++;
            }
        })
    }

    //Search in Table
    function search() {
        if (textSearch.value !== '') {
            page.length = 0;
            onSearch.value = true;
            let count = 0;
            props.dataset.forEach( (row, i) => {
                let str = row[props.fieldSearch]
                let substr = textSearch.value
                
                if (str.indexOf(substr)>= 0) {
                    
                    page[count] = row;
                    count++;
                } 
            })
        } else {
            onSearch.value = false;
            calcPages();
            fillPage(currentPage.value);
            makeLinks(currentPage.value);
        }
    }

    const selectRow = (row, action) => {
        emit('select',[row, action])
    }
    
    onMounted(()=>{
        calcPages();
        fillPage(currentPage.value);
        makeLinks(currentPage.value);
    })

</script>