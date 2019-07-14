//app.js
App({
  onLaunch: function () {
    
    if (!wx.cloud) {
      console.error('请使用 2.2.3 或以上的基础库以使用云能力')
    } else {
      wx.cloud.init({

        env:'z269571627-992fa3',
        // 云开发的环境ID
        traceUser: true,
      })
    }

    this.globalData = {}
  }
})
