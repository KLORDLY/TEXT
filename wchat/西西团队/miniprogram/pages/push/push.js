// pages/push/push.js
const app = getApp()
const db = wx.cloud.database()
const mydb = db.collection('mydb')
Page({

  /**
   * 页面的初始数据,分别是标题、内容、上传的图片数组和id
   */
  data: {
    title: "",
    content:"",
    tempImg: [],
    // 通过wx:for循环遍历图片数组
    fileIDs: [],
  },

//获得标题的值
  titlebind: function (e) {
    if (e.detail && e.detail.value) {
      this.data.title = e.detail.value;
    }
  },

//获取输入框内容
  textbind:function(e){
    if (e.detail && e.detail.value) {
      this.data.content = e.detail.value;
    }
  },

//点击按钮上传照片
uploadimg:function(){
  wx.chooseImage({
    count: 9,
    sizeType: ['original', 'compressed'],
    sourceType: ['album', 'camera'],
    success: res => {
      // tempFilePath可以作为img标签的src属性显示图片
      const tempFilePaths = res.tempFilePaths
      this.setData({
        tempImg: tempFilePaths
      })
    }
  })

},



//提交：打印标题内容及图片
  clicksubmit:function(e){
    
    console.log("用户点击发布","标题："+this.data.title,"内容:"+this.data.content)
    wx.showLoading({
      title: '提交中',
    })

    const promiseArr=[]
    // 在正式上传之前，先声明一个promiseArr数组，因为图片是多张，而上传图片只能是一张一张上传，所以for循环遍历tempImg数组，执行微信给我们的接口wx.cloud.uploadFile()实现图片上传，将每次上传图片的过程都保存在一个Promise对象中，然后将这几个Promise对象push到promiseArr中，把每次上传图片返回的fileID concat()到自己定义的fileIDs数组中，以便等会存入数据集合中。


    //因为只能一张张上传 所以遍历临时的图片数组
    for (let i = 0; i < this.data.tempImg.length; i++) {
      let filePath = this.data.tempImg[i]
      let suffix = /\.[^\.]+$/.exec(filePath)[0]; // 正则表达式，获取文件扩展名

      //在每次上传的时候，就往promiseArr里存一个promise，只有当所有的都返回结果时，才可以继续往下执行
      promiseArr.push(new Promise((reslove, reject) => {
        wx.cloud.uploadFile({
          cloudPath: new Date().getTime() + suffix,
          filePath: filePath, // 文件路径
        }).then(res => {
          // get resource ID
          console.log(res.fileID)
          this.setData({
            fileIDs: this.data.fileIDs.concat("图片id：",res.fileID)
          })
        
          reslove()
        }).catch(error => {
          console.log(error)
        })
      }))
    }
    Promise.all(promiseArr).then(res => {
      db.collection('mydb').add({
        // data 字段表示需新增的 JSON 数据
        data: {
          my_title: this.data.title,
          my_content: this.data.content,
          fileIDs: this.data.fileIDs, //只有当所有的图片都上传完毕后，这个值才能被设置，但是上传文件是一个异步的操作，你不知道他们什么时候把fileid返回，所以就得用promise.all
          done: false
        }
      })
        .then(res => {
          console.log("发布成功",res)
          wx.hideLoading()
          wx.showToast({
            title: '发布成功',
            success:function(){
              wx.switchTab({
                url: '/pages/team/team',
              })
            }
        })

        this.setData({
          forms:""
        })

          var that = this;
          var tempImg = that.data.tempImg;
          tempImg.splice(0, tempImg.length);
          that.setData({
            tempImg
          });
         
    })
        .catch(error => {
          console.log(error)
        })
    })

  },

clickreset:function(){
  var that = this;
  var tempImg = that.data.tempImg;
  
  wx.showModal({
    title: '提示',
    content: '确定要重置吗？',
    success: function (res) {
      if (res.confirm) {
        console.log('用户点击重置了');
        tempImg.splice(0, tempImg.length);
      } else if (res.cancel) {
        console.log('用户点击取消重置了');
        return false;
      }
      that.setData({
        tempImg
      });
    }
  })
},


  deleteImage: function (e) {
    var that = this;
    var tempImg = that.data.tempImg;
    var index = e.currentTarget.dataset.index;//获取当前长按图片下标
    wx.showModal({
      title: '提示',
      content: '确定要删除此图片吗？',
      success: function (res) {
        if (res.confirm) {
          console.log('点击确定了');
          tempImg.splice(index, 1);
        } else if (res.cancel) {
          console.log('点击取消了');
          return false;
        }
        that.setData({
          tempImg
        });
      }
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    wx.setNavigationBarTitle({ title: '发布' })  
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})