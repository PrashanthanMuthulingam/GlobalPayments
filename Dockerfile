# Install dependencies
# If you're using npm@5 or later, this will automatically copy your package-lock.json
RUN npm install

# If you're using rxp-js and SendGrid, you'd likely want them as dependencies
# This is assuming they are not already listed in your package.json
RUN npm install @globalpayments/javascript@latest sendgrid@latest

