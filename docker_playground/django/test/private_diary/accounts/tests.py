import os
from django.test import LiveServerTestCase
from django.urls import reverse_lazy
from selenium import webdriver
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class TestLogin(LiveServerTestCase):
    @classmethod
    def setUpClass(cls):
        super().setUpClass()
        cls.selenium = webdriver.Remote(
            command_executor=os.environ["SELENIUM_URL"],
            desired_capabilities=DesiredCapabilities.CHROME.copy()
        )
    
    @classmethod
    def tearDownClass(cls):
        cls.selenium.quit()
        super().tearDownClass()
    
    def test_login(self):
        # ログインページを開く
        self.selenium.get('http://localhost:8000' + str(reverse_lazy('account_login')))

        # ログイン
        username_input = self.selenium.find_element_by_name("login")
        username_input.send_keys('test@example.com')
        password_input = self.selenium.find_element_by_name("password")
        username_input.send_keys('p@sSw0rd!')
        self.selenium.find_element_by_class_name('btn').click()

        # ページタイトルの検証
        self.assertEquals('日記一覧 | Private Diary', self.selenium.title)