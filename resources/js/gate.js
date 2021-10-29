export default class Gate{

    constructor(user){
        this.user = user;
    }


    isAdmin(){
        return this.user.role_id === '1';
    }
    isSupport(){
        return this.user.role_id === '2';
    }
    isGuest(){
        return this.user.role_id === '3';
    }
    isTechnical(){
        return this.user.role_id === '4';
    }
}

