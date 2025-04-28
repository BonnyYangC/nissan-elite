<template>
    <div class="fgp-content">
        <p class="txt-white">Forgot Password?</p>
        <p class="txt-white">Please enter your registered email address.</p>
        <input class="form-control" id="Email" name="Email" placeholder="Email Address" type="email" v-model="email">
        <button :loading="inProgress" class="btn btn-block fgp-submit-btn" v-on:click="onSubmit($event)">Submit</button>
        <p class="txt-white fs-12">
            Go back to
            <a href="#"><strong class="login-white">login</strong></a>
        </p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inProgress: false,
            email: ''
        };
    },
    watch: {
        email(newValue) {
            //console.log('Email value:', newValue); // For debug, See if email updates
        }
    },
    methods: {
        async onSubmit(e) {
            e.preventDefault();
            if(this.email.trim().length === 0){
                this.$message.error('Please enter your email address!');
            return;
            }
            this.inProgress = true;
            try {
                const response = await axios.get('/reset_password', {
                    params: { email: this.email }
                });
                if (response.status !== 200 || !response.data.success) {
                    this.$message.error('Check your email!');
                    return;
                }
                this.$message(
                    {
                        message: 'Your enquiry has been sent to our support email address',
                        type: 'success'
                    }
                );
            } catch (error) {
                console.error('API error:', error.message);
                this.$message.error('Error sending email: Check your email!');
            }
            this.inProgress = false;
        },
    },
    mounted() {
        // console.log('Component mounted.')
    }
}
</script>
