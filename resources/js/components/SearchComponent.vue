<template>
  <div>
    <el-autocomplete
        v-model="search"
        style="width: 400px;"
        :fetch-suggestions="querySearchAsync"
        placeholder="Find a User By: Firstname Surname"
        @select="handleSelect"
        :empty-text="noDataText"
        :hide-loading="true"
        :trigger-on-focus="false"
        :select-when-unmatched="true">
        <template slot-scope="{ item }">
            <p class="name">{{ item.firstname }} {{ item.lastname }} - {{ item.name }}({{ item.position_code }})</p>
        </template>
    </el-autocomplete>

    <el-dialog
    append-to-body
    title="Question"
    :visible.sync="dialogVisible"
    width="30%">
      <span slot="footer" class="dialog-footer">
          <el-button icon="el-icon-share" type="success" @click="mockHandler">Mock</el-button>
          <el-button icon="el-icon-edit-outline" type="primary" @click="editHandler">Edit</el-button>
          <el-button icon="el-icon-close" @click="dialogVisible = false">Cancel</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: '',
      noDataText: '',
      dialogVisible: false,
      currentItem: null
    };
  },
  watch: {
    search(newValue) {
      // console.log('Search value:', newValue); // For debug, See if search updates
    }
  },
  methods: {
    async querySearchAsync(queryString, callback) {
      // Only search if input length >= 2
      if (queryString.length < 2) {
        this.noDataText = 'Type at least 2 characters...';
        callback([]); // return empty results
        return;
      }
      try {
        const response = await axios.get('/admin/users/search', {
          params: { q: queryString }
        });
        if (response.status !== 200 || !response.data.success) {
          this.noDataText = 'Error fetching users';
          callback([]); // return empty results
          return;
        }
        const data = response.data.data;
        if (data.length === 0) {
          this.noDataText = 'No users found';
        } else {
          this.noDataText = '';
        }

        callback(data);
      } catch (error) {
        console.error('API error:', error);
        this.noDataText = 'Error fetching users';
        callback([]);
      }
    },
    handleSelect(item){
        this.dialogVisible = true;
        this.currentItem = item;
    },
    mockHandler(){
        this.dialogVisible = false;
        if(!this.currentItem.dealer_code){
            // nissan staff
            window.open('/admin/region_staff/mock/' + this.currentItem.id, '_blank');
        }else{
            window.open('/admin/users/mock/' + this.currentItem.id, '_blank');
        }
    },
    editHandler(){
        this.dialogVisible = false;
        window.location.href = '/admin/users/' + this.currentItem.id;
    }
  }
};
</script>