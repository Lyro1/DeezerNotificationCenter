<?php

namespace App\Controller
{

    use JMS\Serializer\SerializationContext;
    use JMS\Serializer\SerializerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;

    class AppController extends AbstractController
    {

        /**
         * @var SerializerInterface serializer interface
         */
        private SerializerInterface $serializer;

        public function __construct(SerializerInterface $serializer)
        {
            $this->serializer = $serializer;
        }

        /**
         * Send response with data and response code
         * @param mixed $data response content
         * @param int $responseCode response code
         * @return Response
         */
        private function response(mixed $data, int $responseCode): Response
        {
            if (is_string($data) || is_null($data))
            {
                $data = is_null($data) ? '' : $data;
                return new Response(is_null($data) ? '' : $data, $responseCode);
            }

            $context = new SerializationContext();
            $context->setSerializeNull(true);
            $jsonError = $this->serializer->serialize($data, 'json', $context);
            return new Response($jsonError, $responseCode, ['Content-Type' => 'application/json']);
        }

        /**
         * Send Bad Request response
         * @param mixed|null $data response content
         * @return Response
         */
        public function badRequest(mixed $data = null): Response
        {
            return $this->response($data, Response::HTTP_BAD_REQUEST);
        }

        /**
         * Send Internal Server Error response
         * @param mixed|null $data response content
         * @return Response
         */
        public function internalServerError(mixed $data = null): Response
        {
            return $this->response($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /**
         * Send Not Found Response
         * @param mixed|null $data response content
         * @return Response
         */
        public function notFound(mixed $data = null): Response
        {
            return $this->response($data, Response::HTTP_NOT_FOUND);
        }

        /**
         * Send Ok response
         * @param mixed|null $data response content
         * @return Response
         */
        public function ok(mixed $data = null): Response
        {
            $hasNoContent = is_null($data);
            return $this->response($data, $hasNoContent ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
        }
    }

}
