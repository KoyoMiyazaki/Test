"""micropost_app URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.urls import path

from .views import static_pages_view
from .views import users_view

app_name = 'micropost'
urlpatterns = [
    path('', static_pages_view.HomeView.as_view(), name="home"),
    path('help/', static_pages_view.HelpView.as_view(), name="help"),
    path('about/', static_pages_view.AboutView.as_view(), name="about"),
    path('contact/', static_pages_view.ContactView.as_view(), name="contact"),
    path('signup/', users_view.UsersView.as_view(), name="users_signup"),
]
