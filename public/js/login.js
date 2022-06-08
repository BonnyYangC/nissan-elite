$(document).ready(function () {
    var fgpApp = new Vue({
        el: '#forgotpassword',
        data:{
            inProgress: false,
            email: ''
        },
        created: function(){},
        methods:{
            onSubmit: function(e){
                e.preventDefault();
                if(this.email.trim().length === 0){
                    this.$message.error('Please enter your email address!');
                    return;
                }
                this.inProgress = true;
                var that = this;
                axios.get(
                    '/reset_password?email=' + this.email
                ).then(function(res){
                    console.log('send email error:', res);
                    debugger;
                    if(res.data.error_no === 100){
                        that.$message(
                            {
                                message: 'Your enquiry has been sent to our support email address',
                                type: 'success'
                            }
                        );
                    }else{
                        that.$message.error('Check your email!');
                        // window.location.href = '/#eligible';
                    }
                    that.inProgress = false;
                });
            }
        }
    })
})