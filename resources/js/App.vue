<template>
    <div class="container mx-auto">
        <MyHeader/>
        <Img/>          
        <SortSearch :lensItems ="this.state.lensItems" @searchData="handleSearchSuccess"/>
        <Modal :titleText ="this.titleText" @saveSuccess="handleSaveSuccess"/>
        <TblSection :newItem ="this.newItem"
                    :searchItem="this.state.searchItems"
                    @getSuccess="handleGetSuccess"/>
    </div>
</template>

<script>
import MyHeader from './components/Header.vue';
import MyHome from './components/Home.vue';
import Img from './components/ImgSection.vue';
import SortSearch from './components/SortSearch.vue';
import Modal from './components/ModalSection.vue';
import TblSection from './components/TblSection.vue';
export default ({
    name: 'App',
    components: { MyHeader, MyHome, Img, SortSearch, Modal, TblSection },
    data(){
        return{
            titleText:"add new entry",
            newItem:{},
            state:{
                lensItems:[],
                searchItems:[]
            }
            
        }
    },
    methods: {
        handleSaveSuccess(newLensData) {
            if(newLensData){
                this.newItem = newLensData;
                // console.log('newLensData : ', newLensData);
                // console.log('this.items: ', this.newItem);
            } 
        },
        handleGetSuccess(newLensData) {
            if(newLensData){
                this.state.lensItems = newLensData;
                console.log('this.state.lensItems: ', this.state.lensItems);
            } 
        },
        handleSearchSuccess(newLensData){
            if(newLensData){
                this.state.searchItems = newLensData;
                console.log('this.state.searchItems: ', this.state.searchItems);
            } 
        }
    }
})
</script>

